<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Constants;
use App\post;
use App\comment;
use App\like_comment;
use App\account;

class CommentServiceController extends Controller
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
        $lst = $request->all();
        if (array_key_exists('post_id', $lst) && $lst['type_comment'] !== null){
            $offset = Constants::OFFSET;
            $limit = Constants::LIMIT;
            if ($request['offset'] != null) {
                $offset = $lst['offset'];
            }
            if ($request['limit'] !=  null) {
                $limit = $lst['limit'];
            }
            if ($lst['type_comment'] !== 'posts' && $lst['type_comment'] !== 'news') {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.input_not_right')
                ];
            } else if ($lst['type_comment'] === 'posts') {
                $comments = comment::where('post_id', '=', $lst['post_id'])->where('comment_level', '=', 1)->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                }
            } else {
                $comments = comment::where('news_id', '=', $lst['post_id'])->where('comment_level', '=', 1)->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                }
            }
            $result = [
                'success' => true,
                'code' => 200,
                'data' => $comments
            ];
            return response()->json($result);
        }
        return  [
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
        $lst = $request->all();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('post_id', $lst) && array_key_exists('comment_content', $lst)) {
            $acceptComment = post::find($lst['post_id']);
            if ($acceptComment->post_comment_status == 0) {
                return [
                    'success' => false,
                    'code' => 400,
                    'message'=> trans('message.can_not_action')
                ];
            }
            $comment = new comment;
            if ($lst['type_comment'] !== 'posts' && $lst['type_comment'] !== 'news') {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.input_not_right')
                ];
            } else if ($lst['type_comment'] === 'posts') {
                $comment->post_id = $lst['post_id'];
            } else {
                $comment->news_id = $lst['post_id'];
            }
            $comment->user_id = $userId;
            $comment->comment_content = $lst['comment_content'];
            if (array_key_exists('comment_id', $lst) && $lst['comment_id'] != null) {
                $comment->comment_level = 2;
                $comment->comment_id = $lst['comment_id'];
            } else {
                $comment->comment_level = 1;
            }
            $success = $comment->save();
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
                      'data' => $comment
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $lst = $request->all();
        if (array_key_exists('post_id', $lst) || $lst['type_comment'] !== null){
            $offset = Constants::OFFSET;
            $limit = Constants::LIMIT;
            if ($request['offset'] != null) {
                $offset = $lst['offset'];
            }
            if ($request['limit'] !=  null) {
                $limit = $lst['limit'];
            }
            if ($lst['type_comment'] !== 'posts' && $lst['type_comment'] !== 'news') {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.input_not_right')
                ];
            } else if ($lst['type_comment'] === 'posts') {
                $comments = comment::where('post_id', '=', $lst['post_id'])->where('comment_level', '=', 2)->where('comment_id', '=', $lst['comment_id'])->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                }
            } else {
                $comments = comment::where('news_id', '=', $lst['post_id'])->where('comment_level', '=', 2)->where('comment_id', '=', $lst['comment_id'])->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                }
            }
            $result = [
                'success' => true,
                'code' => 200,
                'data' => $comments
            ];
            return response()->json($result);
        }
        return  [
            'success' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
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
    public function update(Request $request)
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
        if (array_key_exists('post_id', $lst) || $lst['type_comment'] !== null){
            $commented = comment::where('post_id', '=', $lst['post_id'])->where('comment_id', '=', $lst['comment_id'])->first();
            if (!$commented) {
                return [
                    'success' => false,
                    'code' => 403,
                    'message' => trans('message.not_found')
                ];
            }
            $commented->comment_content = $lst['comment_content'];
            $success = $commented->save();
            if($success != 1){
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
                    'data' => $commented
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('post_id', $lst) && $lst['type_comment'] !== null){
            $comment = comment::find($id);
            if ($comment->user_id != $userId) {
                return [
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.can_not_action')
                ];
            }
            if (!$comment) {
                return [
                    'success' => false,
                    'code' => 403,
                    'message'=> trans('message.not_found_item')
                ];
            }
            $listCommentChildren = comment::where('comment_id', '=', $id)->get();
            for ($i = 0; $i < count($listCommentChildren); $i++) {
                $listCommentChildren[$i]->delete();
            }
            $comment->delete();
            return [
                'success' => true,
                'code' => 200,
                'message'=> trans('message.delete_success'),
                'data' => $comment
            ];
        }
        return  [
            'success' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ];
    }
}
