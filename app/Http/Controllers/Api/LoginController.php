<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\album;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        $credentials = [
            'username' => $req->input('username'),
            'password' => $req->input('passwords')
        ];
        #authentication
        if (!$token = auth('api')->attempt($credentials))
        {
            #Username or Passwords Fail
                return response()->json([
                    'status' => false,
                    'code' => 403,
                    'message' => trans('message.check_login')
                ],403);
        }

        #Login success
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.login_success'),
            'token' => $token
        ],200);
    }

    public function getInfo()
    {
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => trans('message.get_info'),
            'token_data' => auth('api')->user()
        ],200);
    }

    public function getAlbum($id)
    {
        $list = album::where('id_account',$id)->get();
        if(count($list) == null){
            $result = [
                'success' => false,
                  'code' => 404,
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

}
