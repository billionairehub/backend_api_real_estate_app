<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\album;
use App\post;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        $lst = $req->all();
        $errorLogin = 0;
        if (array_key_exists('username', $lst)) {
            $credentials = [
                'username' => $req->input('username'),
                'password' => $req->input('passwords')
            ];
            #authentication
            if (!$token = auth('api')->attempt($credentials))
            {
                $errorLogin = $errorLogin + 1;
            }
            else {
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => trans('message.login_success'),
                    'token' => $token
                ],200);
            }
        }
        if (array_key_exists('email', $lst)) {
            $credentials = [
                'email' => $req->input('email'),
                'password' => $req->input('passwords')
            ];
            
            #authentication
            if (!$token = auth('api')->attempt($credentials))
            {
                $errorLogin = $errorLogin + 1;
            }
            #Login success
            else {
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => trans('message.login_success'),
                    'token' => $token
                ],200);
            }
        }
        if (array_key_exists('phone', $lst)) {
            $credentials = [
                'phone' => $req->input('phone'),
                'password' => $req->input('passwords')
            ];
            
            #authentication
            if (!$token = auth('api')->attempt($credentials))
            {
                $errorLogin = $errorLogin + 1;
            }
            else {
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => trans('message.login_success'),
                    'token' => $token
                ],200);
            }
        }
        if ($errorLogin > 0) {
            return response()->json([
                'status' => false,
                'code' => 400,
                'message' => trans('message.check_login')
            ],400);
        }
    }

    public function getInfo()
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return response()->json( [
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.get_info'),
            'token_data' => auth('api')->user()
        ],200);
    }

   public function getAlbum()
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $list = album::where('id_account', $userId)->get();
        $post = post::where('post_author', $userId)->get('post_image');
        $arr = [];
        for ($i = 0; $i < count($post); $i++) {
            $post[$i]->post_image = explode(',' , $post[$i]->post_image);
            array_push($arr, $post[$i]->post_image);
        }

        if(count($list) == 0 && count($post) == 0){
            $result = [
                'status' => false,
                'code' => 200,
                'message' => trans('message.status_fail'),
                'data' => null
            ];
        }
        else {
            $result = [
              'status' => true,
              'code' => 200,
              'message' => trans('message.status_pass'),
              'data' => $list,
              'post_img' => $arr[1]
            ];
        }
        return response()->json($result);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.logout_sucess')
        ]);

    }

}