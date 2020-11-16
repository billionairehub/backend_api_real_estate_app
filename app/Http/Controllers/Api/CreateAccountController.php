<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\account;
use App\album;
use App\news;
use App\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Mail;
use DB;
class CreateAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }
        $list = account::all();
        if(count($list) == 0){
            $result = response()->json([
                'status' => false,
                  'code' => 404,
                  'message'=> trans('message.status_fail'),
                  'data' => null
            ], 404);
        }
        else {
            $result = response()->json([
              'success' => true,
              'code' => 200,
              'message'=> trans('message.status_pass'),
              'data' => $list
            ], 200);
        }
        return $result;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $lst = $request->all();
      if (array_key_exists('username', $lst) == false || array_key_exists('phone', $lst) == false || array_key_exists('email', $lst) == false || array_key_exists('passwords', $lst) == false || $lst['username'] == null || $lst['phone'] == null || $lst['email'] == null || $lst['passwords'] == null) {
        return response()->json([
            'status' => false,
            'code' => 400,
            'message'=> trans('message.please_fill_out_the_form')
        ], 400);
    }
        $list = account::where('username', $request->input('username'))
                               ->orWhere('phone', $request->input('phone'))
                               ->orWhere('email', $request->input('email'))
                               ->first();
        if($list){
            $result = response()->json([
                'status' => false,
                'code' => 400,
                  'message'=> trans('message.data_exist'),
                  'data' => null
            ], 400);
            return $result;
        }
        $listdata = new account;
        $album = new album;
        $now = Carbon::now();
    if( array_key_exists('url_avata', $lst) || $request->hasFile('url_avata') != null )
    {
      $img = Hash::make($request->file('url_avata'));
      $photo_name = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
      $path = $request->file('url_avata')->move('./image_avata', $photo_name);
      $img_url = asset('/image_avata/'.$photo_name);
      $listdata->url_avata = $img_url;
      $album->album_avt = $img_url;
    }
    else 
    {
     $listdata->url_avata = NULL;
    }
    if(array_key_exists('url_cover_image', $lst) || $request->hasFile('url_cover_image') != null )
    {
      $img_cover = Hash::make($request->file('url_cover_image'));
      $photo_name_cover = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
      $path_cover = $request->file('url_cover_image')->move('./image_cover', $photo_name_cover);
      $img_url_cover = asset('/image_cover/'.$photo_name_cover);
      $listdata->url_cover_image = $img_url_cover;
      $album->album_cover = $img_url_cover;
    }
    else 
    {
      $listdata->url_cover_image = NULL;
    }
        if (preg_match('/^[a-zA-Z0-9]{6,30}$/', $request->input('username'))) {
            $listdata->username = $request->input('username');
        }
        else {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => trans('message.username_data_invalid'),
                'data' => null
            ], 400);
        }
        if (preg_match('/^[0][0-9]{9,10}+$/', $request->input('phone'))) {
            $listdata->phone = $request->input('phone');
        }
        else {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => trans('message.phone_data_invalid'),
                'data' => null
            ], 400);
        }
        if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) == false) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => trans('message.email_data_invalid'),
                'data' => null
            ], 400);
        }
        else {
            $listdata->email = $request->input('email'); 
        }
        $listdata->personal_infor = $request->input('personal_infor');
        $listdata->id_token_faceboook = $request->input('id_token_faceboook'); 
        $listdata->id_token_google = $request->input('id_token_google'); 
        $listdata->birth_date = Carbon::parse($request->input('birth_date'))->format('Y.m.d'); 
        $listdata->passwords = Hash::make($request->passwords);
        $list = account::all();
        $album->id_account = (int)count($list) + 1;
        if(( array_key_exists('url_avata', $lst) || $request->hasFile('url_avata') != null ) || (array_key_exists('url_cover_image', $lst) || $request->hasFile('url_cover_image') != null ) ) 
          {
            $album->save();
          }
        $info = $listdata->save();
        //printf($info);
        if($info != 1){
            $result = response()->json([
                  'status' => false,
                  'code' => 400,
                  'message'=> trans('message.add_unsuccess'),
                  'data' => null
            ], 400);
        }else{
            $result = response()->json([
                  'success' => true,
                  'code' => 200,
                  'message'=> trans('message.add_success'),
                  'data' => $listdata,
                  'data_album' => $album
            ], 200);
        }
        return $result;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }
        $list = account::find($id);
        if($list == null){
            $result = response()->json([
              'status' => false,
              'code' => 400,
              'message' => trans('message.status_fail'),
              'data' => null
            ], 400);
        }
        else {
            $projects = news::where('news_author', $id)->get();
            for ($i = 0; $i < count($projects); $i++) {
                $projects[$i]->news_image = str_replace(' ', '', $projects[$i]->news_image);
                $projects[$i]->news_image = explode(',', $projects[$i]->news_image);
                $projects[$i]->news_logo = explode(',', $projects[$i]->news_logo);
                $projects[$i]->news_feature_image = explode(',', $projects[$i]->news_feature_image);
                $author = account::where('id', $projects[$i]->news_author)->first();
                $projects[$i]->news_author = $author;
            }
            $posts = post::where('post_author', $id)->get();
            for ($i = 0; $i < count($posts); $i++) {
                $posts[$i]->post_image = str_replace(' ', '', $posts[$i]->post_image);
                $posts[$i]->post_image  = explode(',', $posts[$i]->post_image);
                $author = account::where('id', $posts[$i]->post_author)->first();
                $posts[$i]->post_author = $author;
            }
            // $list->projects = $projects;
            // $list->posts = $posts;
            $result = response()->json([
              'success' => true,
              'code' => 200,
              'message' => trans('message.status_pass'),
              'data' => $list,
              'projects' => $projects,
              'posts' => $posts
            ], 200);
        }
        return $result;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lst = $request->all();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }
        $listdata = account::find($userId);
        if(!$listdata) {
          return $result = response()->json([
                  'status' => false,
                  'code' => 400,
                  'message' => trans('message.data_not_exist'),
                  'data' => null
            ], 400);
        }
        if (array_key_exists('personal_infor', $lst)) {
            $listdata->personal_infor = $request->input('personal_infor');
        }
        if (array_key_exists('id_token_faceboook', $lst)) {
            $listdata->id_token_faceboook = $request->input('id_token_faceboook'); 
        }
        if (array_key_exists('id_token_google', $lst)) {
            $listdata->id_token_google = $request->input('id_token_google'); 
        }
        if (array_key_exists('birth_date', $lst)) {
            $listdata->birth_date = Carbon::parse($request->input('birth_date'))->format('Y.m.d'); 
        }
        if (array_key_exists('passwords', $lst)) {
            $listdata->passwords = Hash::make($request->passwords);
        }
        $album = new album;
        if (array_key_exists('url_avata', $lst)){
            $img = Hash::make($request->file('url_avata'));
            $now = Carbon::now();
            $photo_name = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
            $path = $request->file('url_avata')->move('./image_avata', $photo_name);
            $img_url = asset('/image_avata/'.$photo_name);
            $listdata->url_avata = $img_url;
            $album->album_avt = $img_url;
        } else {
            $album->album_avt = $listdata->url_avata;
        }
        if (array_key_exists('url_cover_image', $lst)){
            $img_cover = Hash::make($request->file('url_cover_image'));
            $now = Carbon::now();
            $photo_name_cover = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
            $path_cover = $request->file('url_cover_image')->move('./image_cover', $photo_name_cover);
            $img_url_cover = asset('/image_cover/'.$photo_name_cover);
            $listdata->url_cover_image = $img_url_cover;
            $album->album_cover = $img_url_cover;
        } else {
            $album->album_cover = $listdata->url_cover_image;
        }
        $album->id_account = $userId;
        $img = $album->save();
        $result = response()->json([
            'status' => false,
            'code' => 400,
            'message' => trans('message.data_exist'),
            'data' => null
        ], 400);
        $data = [];
        if (array_key_exists('phone', $lst)) {
            $data = account::where('phone', $request->input('phone'))->first();
            if ($data) {
                if ($data->phone != $listdata->phone) {
                    return $result;
                }
            }
            if (preg_match('/^[0][0-9]{9,10}+$/', $request->input('phone'))) {
                $listdata->phone = $request->input('phone');
            }
            else {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => trans('message.phone_data_invalid'),
                    'data' => null
                ], 400);
            }
        }
        if (array_key_exists('username', $lst)) {
            $data = account::where('username', $request->input('username'))->first();
            if ($data) {
                if ($data->username != $listdata->username) {
                    return $result;
                }
            }
            if (preg_match('/^[a-zA-Z0-9]{6,30}$/', $request->input('username'))) {
                $listdata->username = $request->input('username');
            }
            else {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => trans('message.username_data_invalid'),
                    'data' => null
                ], 400);
            }
            $listdata->username = $request->input('username');
        }
        if (array_key_exists('email', $lst)) {
            $data = account::where('email', $request->input('email'))->first();
            if ($data) {
                if ($data->email != $listdata->email) {
                    return $result;
                }
            }
            if (filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) == false) {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => trans('message.email_data_invalid'),
                    'data' => null
                ], 400);
            }
            else {
                $listdata->email = $request->input('email'); 
            }
        }
        $info = $listdata->save();
        if($info != 1){
            $result = response()->json([
                  'status' => false,
                  'code' => 400,
                  'message'=> trans('message.upate_unsuccess'),
                  'data' => null
            ], 400);
        }else{
            $result = response()->json([
                  'success' => true,
                  'code' => 200,
                  'message'=> trans('message.upate_success'),
                  'data' => $listdata,
                  'img' => $album
            ], 200);
        }
        return $result;
    }
    public function updatePassword (Request $request) {
        $lst = $request->all();
        $username = auth('api')->user()->username;
        if ($username) {
            if (array_key_exists('old_password', $lst) && $lst['old_password'] != null && array_key_exists('new_password', $lst) && $lst['new_password'] != null) {
                $credentials = [
                    'username' => $username,
                    'password' => $lst['old_password']
                ];
                if (Auth::attempt($credentials) == false) {
                    return response()->json([
                        'status' => false,
                        'code' => 400,
                        'message'=> trans('message.password_is_not_right')
                    ], 400);
                } else {
                    $userId = auth('api')->user()->id;
                    $listdata = account::find($userId);
                    $listdata->passwords = Hash::make($request->new_password);
                    $listdata->save();
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message'=> trans('message.success')
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message'=> trans('message.please_fill_out_the_form')
                ], 400);
            }
        }
        return  response()->json([
            'status' => false,
            'code' => 401,
            'message' => trans('message.unauthenticate')
      ], 401);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}