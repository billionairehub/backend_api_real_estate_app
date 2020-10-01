<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Constants;
use App\like_comment;
use App\account;
use DB;

class LikeCommentServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lst = $request->all();;
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('id_comment', $lst) && $lst['id_comment'] !=  null) {
            $like_comment = like_comment::where('id_comment', '=', $lst['id_comment'])->get();
            return [
                'success' => false,
                'code' => 400,
                'message'=> trans('message.status_pass'),
                'data' => $like_comment
            ];
        }
        return [
            'success' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $lst = $request->all();;
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('id_comment', $lst) && $lst['id_comment'] !=  null) {
            $like_comment = like_comment::where('id_comment', '=', $lst['id_comment'])->where('id_account_like', '=', $userId)->first();
            if ($like_comment) {
                return [
                    'success' => false,
                    'code' => 400,
                    'message' => trans('message.can_not_action')
                ];
            }
            $like_comment = new like_comment;
            $like_comment->id_comment = $lst['id_comment'];
            $like_comment->id_account_like = $userId;
            $success = $like_comment->save();
            if($success != 1){
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
                      'data' => $like_comment
                ];
            }
            return response()->json($result);
        }
        return [
            'success' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ];
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
    public function destroy(Request $request)
    {
        $userId = auth('api')->user()->id;
        $lst = $request->all();
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('id_comment', $lst) && $lst['id_comment'] !=  null) {
            $like_comment = like_comment::where('id_comment', '=', $lst['id_comment'])->where('id_account_like', '=', $userId)->first();
            if (!$like_comment) {
                return  [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.data_not_exist')
              ];
            }
            $like_comment->delete();
            return [
                'success' => true,
                'code' => 200,
                'message'=> trans('message.delete_success'),
                'data' => $like_comment
            ];
        }
        return [
            'success' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ];
    }
}
