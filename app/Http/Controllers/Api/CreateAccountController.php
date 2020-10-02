<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\account;
use App\album;
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
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $list = account::all();
        if(count($list)){
            $result = [
                'success' => false,
                  'code' => 404,
                  'message'=> trans('message.status_fail'),
                  'data' => null
            ];
        }
        else {
            $result = [
              'success' => true,
              'code' => 200,
              'message'=> trans('message.status_pass'),
              'data' => $list
            ];
        }
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = account::where('username', $request->input('username'))
                               ->orWhere('phone', $request->input('phone'))
                               ->orWhere('email', $request->input('email'))
                               ->first();
        if($list){
            $result = [
                'success' => false,
                'code' => 205,
                  'message'=> trans('message.data_exist'),
                  'data' => null
            ];
            return $result;
        }
        $listdata = new account;
        $listdata->username = $request->input('username');
        $listdata->phone = $request->input('phone');
        $listdata->email = $request->input('email'); 
        $img = Hash::make($request->file('url_avata'));
        $now = Carbon::now();
        $photo_name = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
        $path = $request->file('url_avata')->move('./image_avata', $photo_name);
        $img_url = asset('/image_avata/'.$photo_name);
        $listdata->url_avata = $img_url;
        $listdata->personal_infor = $request->input('personal_infor');
        $img_cover = Hash::make($request->file('url_cover_image'));
        $photo_name_cover = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
        $path_cover = $request->file('url_cover_image')->move('./image_cover', $photo_name_cover);
        $img_url_cover = asset('/image_cover/'.$photo_name_cover);
        $listdata->url_cover_image = $img_url_cover;

        $listdata->id_token_faceboook = $request->input('id_token_faceboook'); 
        $listdata->id_token_google = $request->input('id_token_google'); 
        $listdata->birth_date = Carbon::parse($request->input('birth_date'))->format('Y.m.d'); 
        $listdata->passwords = Hash::make($request->passwords);

        $album = new album;
        $list = account::all();
        $album->id_account = (int)count($list) + 1;
        $album->album_avt = $img_url;
        $album->album_cover = $img_url_cover;

        $album->save();
        $info = $listdata->save();
        //printf($info);
        if($info != 1){
            $result = [
                  'success' => false,
                  'code' => 400,
                  'message'=> trans('message.add_unsuccess'),
                  'data' => null
            ];
        }else{
            $result = [
                  'success' => true,
                  'code' => 200,
                  'message'=> trans('message.add_success'),
                  'data' => $listdata,
                  'data_album' => $album
            ];
        }
        return response()->json($result);
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
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $list = account::find($id);
        
        if($list == null){
            $result = [
              'success' => false,
              'code' => 205,
              'message' => trans('message.status_fail'),
              'data' => null
            ];
        }
        else {
            $result = [
              'success' => true,
              'code' => 200,
              'message' => trans('message.status_pass'),
              'data' => $list
            ];
        }
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $listdata = account::find($userId);
        if(!$listdata) {
          return $result = [
                  'success' => false,
                  'code' => 205,
                  'message' => trans('message.data_not_exist'),
                  'data' => null
            ];
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

        $lst = $request->all();
        $result = [
            'success' => false,
            'code' => 205,
            'message' => trans('message.data_exist'),
            'data' => null
        ];
        $data = [];
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
        $album->id_account = $id;
        $img = $album->save();
        if (array_key_exists('phone', $lst)) {
            $data = account::where('phone', $request->input('phone'))->first();
            if ($data) {
                return $result;
            }
            $listdata->phone = $request->input('phone');
        }
        if (array_key_exists('username', $lst)) {
            $data = account::where('username', $request->input('username'))->first();
            if ($data) {
                return $result;
            }
            $listdata->username = $request->input('username');
        }
        if (array_key_exists('email', $lst)) {
            $data = account::where('email', $request->input('email'))->first();
            if ($data) {
                return $result;
            }
            $listdata->email = $request->input('email'); 
        }
        $info = $listdata->save();
        if($info != 1){
            $result = [
                  'success' => false,
                  'code' => 400,
                  'message'=> trans('message.upate_unsuccess'),
                  'data' => null
            ];
        }else{
            $result = [
                  'success' => true,
                  'code' => 200,
                  'message'=> trans('message.upate_success'),
                  'data' => $listdata,
                  'img' => $album
            ];
        }
        return response()->json($result);
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
