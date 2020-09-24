<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\account;
use App\album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
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
        $list = account::all();
        //printf($list);
        if(count($list) == null){
            $result = [
                'success' => false,
                  'code' => 404,
                  'message'=>'Lấy danh sách thất bại',
                  'data' => null
            ];
        }
        else {
            $result = [
              'success' => true,
              'code' => 200,
              'message'=>'Lấy danh sách thành công',
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
        $list = account::where('username', '=', $request->input('username'))
                               ->orWhere('phone', '=', $request->input('phone'))
                               ->orWhere('email', '=', $request->input('email'))
                               ->orWhere('id_token_faceboook', '=', $request->input('id_token_faceboook'))
                               ->orWhere('id_token_google', '=', $request->input('id_token_google'))
                               ->exists();
        if($list){
            $result = [
                'success' => false,
                  'code' => 205,
                  'message'=>'Thông tin tài khoản đã tồn tại',
                  'data' => null
            ];
            return $result;
        }
        
        //printf($img, $img_url);
        $DanhSach = new account;
        $DanhSach->username = $request->input('username');
        $DanhSach->phone = $request->input('phone');
        $DanhSach->email = $request->input('email'); 
        $img = Hash::make($request->file('url_avata'));
        $now = Carbon::now();
        $photo_name = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
        $path = $request->file('url_avata')->move('./image_avata', $photo_name);
        $img_url = asset('/image_avata/'.$photo_name);
        $DanhSach->url_avata = $img_url;
        $DanhSach->personal_infor = $request->input('personal_infor');
        $img_cover = Hash::make($request->file('url_cover_image'));
        $photo_name_cover = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
        $path_cover = $request->file('url_cover_image')->move('./image_cover', $photo_name_cover);
        $img_url_cover = asset('/image_cover/'.$photo_name_cover);
        $DanhSach->url_cover_image = $img_url_cover;

        $DanhSach->id_token_faceboook = $request->input('id_token_faceboook'); 
        $DanhSach->id_token_google = $request->input('id_token_google'); 
        $DanhSach->birth_date = Carbon::parse($request->input('birth_date'))->format('Y.m.d'); 
        $DanhSach->passwords = Hash::make($request->passwords);

        $album = new album;
        $list = account::all();
        $album->id_account = (int)count($list) + 1;
        $album->album_avt = $img_url;
        $album->album_cover = $img_url_cover;

        $album->save();
        $info = $DanhSach->save();
        //printf($info);
        if($info != 1){
            $result = [
                  'success' => false,
                  'code' => 400,
                  'message'=>'Thêm tài khoản không thành công',
                  'data' => null
            ];
        }else{
            $result = [
                  'success' => true,
                  'code' => 200,
                  'message'=>'Thêm tài khoản thành công',
                  'data' => $DanhSach,
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
        $list = account::find($id);
        //printf($list);
        if($list == null){
            $result = [
                'success' => false,
                  'code' => 205,
                  'message'=>'Lấy danh sách thất bại',
                  'data' => null
            ];
        }
        else {
            $result = [
              'success' => true,
              'code' => 200,
              'message'=>'Lấy danh sách thành công',
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
        $DanhSach = account::find($id);
        if(!$DanhSach) {
          return $result = [
                  'success' => false,
                  'code' => 205,
                  'message'=>'Tài khoản không tồn tại',
                  'data' => null
            ];
        }

        $DanhSach->username = $request->input('username');
        $DanhSach->phone = $request->input('phone');
        $DanhSach->email = $request->input('email'); 
        $img = Hash::make($request->file('url_avata'));
        $now = Carbon::now();
        $photo_name = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
        $path = $request->file('url_avata')->move('./image_avata', $photo_name);
        $img_url = asset('/image_avata/'.$photo_name);
        $DanhSach->url_avata = $img_url;

        $DanhSach->personal_infor = $request->input('personal_infor');

        $img_cover = Hash::make($request->file('url_cover_image'));
        $photo_name_cover = Carbon::parse($now)->format('Y_m_d_H_i_s').time().'.png';
        $path_cover = $request->file('url_cover_image')->move('./image_cover', $photo_name_cover);
        $img_url_cover = asset('/image_cover/'.$photo_name_cover);
        $DanhSach->url_cover_image = $img_url_cover;

        $DanhSach->id_token_faceboook = $request->input('id_token_faceboook'); 
        $DanhSach->id_token_google = $request->input('id_token_google'); 
        $DanhSach->birth_date = Carbon::parse($request->input('birth_date'))->format('Y.m.d'); 
        $DanhSach->passwords = Hash::make($request->passwords);

        $album = new album;
        $album->id_account = $id;
        $album->album_avt = $img_url;
        $album->album_cover = $img_url_cover;
        $img = $album->save();

        $info = $DanhSach->save();
        //printf($info);
        if($info != 1){
            $result = [
                  'success' => false,
                  'code' => 400,
                  'message'=>'Cập nhật tài khoản không thành công',
                  'data' => null
            ];
        }else{
            $result = [
                  'success' => true,
                  'code' => 200,
                  'message'=>'Cập nhật tài khoản thành công',
                  'data' => $DanhSach,
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
