<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\like;

class LikeServiceController extends Controller
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

    public function like (Request $request) {
        $userId = auth('api')->user()->id;
        $lst = $request->all();
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $liked = like::where('id_post', '=' , $lst['id_post'])->where('id_account_like', '=', $userId)->first();
            
        if ($liked) {
            return [
                'success' => false,
                'code' => 401,
                'message' => trans('message.can_not_action')
            ];
        }
        $like = new like;
        $like->id_post = $lst['id_post'];
        $like->id_account_like = $userId;
        
        $success = $like->save();

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
                  'data' => $like
            ];
        }
        return response()->json($result);
    }

    public function unlike (Request $request) {
        $userId = auth('api')->user()->id;
        $lst = $request->all();
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $liked = like::where('id_post', '=' , $lst['id_post'])->where('id_account_like', '=', $userId)->first();
        if (!$liked) {
            return [
                'success' => false,
                'code' => 401,
                'message' => trans('message.can_not_action')
            ];
        }
        $liked->delete();
        return [
            'success' => true,
            'code' => 200,
            'message'=> trans('message.delete_success'),
            'data' => $liked
        ];
    }
}
