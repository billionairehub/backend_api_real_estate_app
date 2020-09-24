<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $req)
    {
        $credentials = [
            'username' => $req->input('username'),
            'password' => $req->input('passwords')
        ];
        //dd($credentials);
        #chứng thực
        if (!$token = auth('api')->attempt($credentials))
        {
            //dd($token);
            # Sai Tên Đăng Nhập và Mật Khẩu
                return response()->json([
                    'status' => false,
                    'code' => 403,
                    'message' => 'Username or Password invalid.'
                ],403);
        }

        #Trả về đăng nhập đúng
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Login Success!.',
            'token' => $token,
            'type' => 'bearer',# có thể bỏ
            'expires' => auth('api')->user()
        ],200);
    }

    public function laythongtin()
    {
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Lấy thông tin thành công.',
            'data' => auth('api')->user()
        ],200);
    }

}
