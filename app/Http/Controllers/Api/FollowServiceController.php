<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Constants;
use App\follow;
use App\account;

class FollowServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $offset = Constants::OFFSET;
        $limit = Constants::LIMIT;
        if ($request['offset'] != null) {
            $offset = $lst['offset'];
        }
        if ($request['limit'] !=  null) {
            $limit = $lst['limit'];
        }
        $follow = follow::where('id_account', '=', $userId)->limit($limit)->offset($offset)->get();
        for ($i = 0; $i < count($follow); $i++) {
            $user = account::where('id', '=', $follow[$i]->id_followers)->first();
            $follow[$i]->id_followers = $user;
        }
        $result = [
            'success' => true,
            'code' => 200,
            'data' => $follow
        ];
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $lst = $request->all();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('followers', $lst) && $lst['followers'] != null) {
            if ($lst['followers'] == $userId) {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.can_not_action')
                ];
            }
            $followers = account::where('id', '=', $lst['followers'])->first();
            if (!$followers) {
                return [
                    'success' => false,
                    'code' => 403,
                    'message' => trans('message.not_found')
                ];
            }
            $follow = new follow;
            $follow->id_account = $userId;
            $follow->id_followers = $lst['followers'];
            $success = $follow->save();

            if($success != 1){
                $result = [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.add_unsuccess'),
                    'data' => null
                ];
            } else {
                $result = [
                    'success' => true,
                    'code' => 200,
                    'message'=> trans('message.add_success'),
                    'data' => $follow
                ];
            }
            return response()->json($result);
        }
        return [
            'success' => false,
            'code' => 401,
            'message' => trans('message.not_found_item')
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
        $lst = $request->all();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('followers', $lst) && $lst['followers'] != null) {
            if ($lst['followers'] == $userId) {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.can_not_action')
                ];
            }
            $followers = account::where('id', '=', $lst['followers'])->first();
            if (!$followers) {
                return [
                    'success' => false,
                    'code' => 403,
                    'message' => trans('message.not_found')
                ];
            }
            $unfollow = follow::where('id_followers', '=' , $lst['followers'])->where('id_account', '=', $userId)->first();
            if (!$unfollow) {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.can_not_action')
                ];
            }
            $unfollow->delete();
            return [
                'success' => true,
                'code' => 200,
                'message'=> trans('message.delete_success'),
                'data' => $unfollow
            ];
        }
        return [
            'success' => false,
            'code' => 401,
            'message' => trans('message.not_found_item')
        ];
    }
}
