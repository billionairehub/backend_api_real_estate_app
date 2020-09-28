<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\account;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Mail;

class MailServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendCode(Request $request) {
        $lst = $request->all();
        if (array_key_exists('email', $lst)) {
            // Email
            $input = strtolower($request->email);
            $accounExists = account::where('email', $input)->first();
            if (!$accounExists) {
                return  [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.not_information')
                ];
            }
            $code = $this->generateRandomString();
            $timeExpireds = (Carbon::now()->timestamp) * 1000 + 3600000;
            $data = array('emailto'=>$input, 'code'=>$code);
            $update = account::where('email', $input)->update(['code' => $code, 'code_time_expireds' => $timeExpireds]);
            Mail::send(['html'=>'templateEmail'],$data, function($message) use ($data){
                $message->to(reset($data), '')->subject('Quên mật khẩu');
                $message->from('noreply.sharingroom@gmail.com', "noreply.sharingroom@gmail.com");
            });
            $result = [
                'success' => true,
                'code' => 200,
                'message'=> trans('Send code success')
            ];
            return $result;
        } else if (array_key_exists('phone', $lst)) {
            // Phone Number
        } else {
            return [
                'success' => false,
                'code' => 400,
                'message'=> trans('message.not_information')
            ];
        }
    }

    public function checkCodeEmail(Request $request) {
        $lst = $request->all();
        if (array_key_exists('email', $lst) && array_key_exists('code', $lst)) {
            $input = strtolower($request->email);
            $accounExists = account::where('email', $input)->first();
            if (!$accounExists) {
                return  [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.not_information')
                ];
            }
            $time_now = (Carbon::now()->timestamp) * 1000;
            if (($accounExists->code_time_expireds - $time_now) >= 0) {
                if ($accounExists->code === $lst['code']) {
                    $update = account::where('email', $input)->update(['code' => null, 'code_time_expireds' => ((Carbon::now()->timestamp) * 1000 + 3600000)]);
                    return [
                        'success' => true,
                        'code' => 200,
                        'message'=> trans('message.success')
                    ];
                } else {
                    return [
                        'success' => false,
                        'code' => 400,
                        'message'=> trans('message.code_invalid')
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.time_expireds')
                ];
            }
        } else {
            return [
                'success' => false,
                'code' => 400,
                'message'=> trans('message.please_fill_out_the_form')
            ];
        }
    }

    public function changePassword(Request $request) {
        $lst = $request->all();
        if (array_key_exists('email', $lst) && array_key_exists('password', $lst) && array_key_exists('repassword', $lst)) {
            $input = strtolower($request->email);
            $accounExists = account::where('email', $input)->first();
            if (!$accounExists) {
                return  [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.not_information')
                ];
            }
            $time_now = (Carbon::now()->timestamp) * 1000;
            if (($accounExists->code_time_expireds - $time_now) >= 0) {
                if ($lst['password'] === $lst['repassword']) {
                    $newpassword = Hash::make($request->password);
                    $update = account::where('email', $input)->update(['code_time_expireds'=>null, 'passwords'=>$newpassword]);
                    return [
                        'success' => true,
                        'code' => 200,
                        'message'=> trans('message.success')
                    ];
                } else {
                    return [
                        'success' => false,
                        'code' => 400,
                        'message'=> trans('message.password_not_same')
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.time_expireds')
                ];
            }
        } else {
            return [
                'success' => false,
                'code' => 400,
                'message'=> trans('message.please_fill_out_the_form')
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
