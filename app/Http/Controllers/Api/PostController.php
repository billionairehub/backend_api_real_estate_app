<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Constants;
use App\post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lst = $request->all();
        $offset = Constants::OFFSET;
        $limit = Constants::LIMIT;
        if ($request['offset'] != null) {
            $offset = $lst['offset'];
        }
        if ($request['limit'] !=  null) {
            $limit = $lst['limit'];
        }
        $posts = post::limit($limit)->offset($offset)->get();
        $data = [];
        for ($i = 0; $i < $limit; $i++) {
            $posts[$i]->post_image = explode(',', $posts[$i]->post_image);
            array_push($data, $posts[$i]);
        }
        $result = [
            'success' => true,
            'code' => 200,
            'data' => $posts
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
        if (array_key_exists('post_content', $lst) && array_key_exists('post_image', $lst)) {
            $lst = $request->all();
            $post = new post;
            $post->post_author = $userId;
            $post->post_content = $lst['post_content'];
            $post->post_image = $lst['post_image'];
            $post->post_status = Constants::STATUS_POST_PUBLISHED;
            $post->post_comment_status = Constants::STATUS_COMMENT_POST_UNBLOCK;
            $success = $post->save();
            if($success != 1){
                $result = [
                      'success' => false,
                      'code' => 400,
                      'message'=> trans('message.add_unsuccess'),
                      'data' => null
                ];
            }else{
                $post->post_image = explode(',', $post->post_image);
                $result = [
                      'success' => true,
                      'code' => 200,
                      'message'=> trans('message.add_success'),
                      'data' => $post
                ];
            }
            return response()->json($result);
        }
        return  [
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = post::where('id', $id)->get();
        if (count($data) == 0) {
             return [
                'success' => false,
                'code' => 403,
                'message' => trans('message.not_found_item')
             ];
        }
        $data[0]->post_image = explode(',', $data[0]->post_image);
        return [
            'success' => true,
            'code' => 200,
            'message' => trans('message.success'),
            'data' => $data
        ];
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
        $lst = $request->all();
        $post = post::find($id);
        if (!$post) {
             return [
                'success' => false,
                'code' => 403,
                'message' => trans('message.not_found_item')
             ];
        }
        if (array_key_exists('post_content', $lst)) {
            $post->post_content = $lst['post_content'];
        }
        if (array_key_exists('post_image', $lst)) {
            $post->post_image = $lst['post_image'];
        }
        if (array_key_exists('post_status', $lst)) {
            $post->post_status = Constants::STATUS_POST_PUBLISHED;
        }
        if (array_key_exists('post_comment_status', $lst)) {
            $post->post_comment_status = Constants::STATUS_COMMENT_POST_UNBLOCK;
        }
        $newdata = $post->save();
        if($newdata != 1){
            $result = [
                  'success' => false,
                  'code' => 400,
                  'message'=> trans('message.upate_unsuccess'),
                  'data' => null
            ];
        }else{
            $post->post_image = explode(',', $post->post_image);
            $result = [
                  'success' => true,
                  'code' => 200,
                  'message'=> trans('message.upate_success'),
                  'data' => $post
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
        $post = post::find($id);
        if (!$post) {
            return [
                'success' => false,
                'code' => 403,
                'message'=> trans('message.not_found_item')
            ];
        }
        $post->delete();
        $post->post_image = explode(',', $post->post_image);
        return [
            'success' => true,
            'code' => 200,
            'message'=> trans('message.delete_success'),
            'data' => $post
        ];
    }
}
