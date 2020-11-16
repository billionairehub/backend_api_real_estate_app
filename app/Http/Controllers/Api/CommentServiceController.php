<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Constants;
use App\post;
use App\news;
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
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
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
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => trans('message.input_not_right')
                ], 400);
            } else if ($lst['type_comment'] === 'posts') {
                $comments = comment::where('post_id', '=', $lst['post_id'])->where('comment_level', 1)->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                    $liker = account::where('id', '=', $comments[$i]->user_id)->first();
                    $count_comment = comment::where('post_id', '=', $lst['post_id'])->where('comment_id', '=', $comments[$i]->id)->where('comment_level', '=', 2)->get()->count();
                    $comments[$i]->count_comment = $count_comment;
                    $comments[$i]->user_id = $liker;
                }
            } else {
                $comments = comment::where('news_id', '=', $lst['post_id'])->where('comment_level', '=', 1)->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                    $liker = account::where('id', '=', $comments[$i]->user_id)->first();
                    $count_comment = comment::where('news_id', '=', $lst['post_id'])->where('comment_id', '=', $comments[$i]->id)->where('comment_level', '=', 2)->get()->count();
                    $comments[$i]->count_comment = $count_comment;
                    $comments[$i]->user_id = $liker;
                }
            }
            $result = [
                'status' => true,
                'code' => 200,
                'message' => trans('message.status_pass'),
                'data' => $comments
            ];
            return response()->json($result);
        }
        return  response()->json([
            'status' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ], 400);
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
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }
        if (array_key_exists('post_id', $lst) && array_key_exists('comment_content', $lst)) {
            if ($lst['type_comment'] == 'posts') {
                $acceptComment = post::find($lst['post_id']);
                if ($acceptComment->post_comment_status == 0) {
                    return response()->json([
                        'status' => false,
                        'code' => 400,
                        'message'=> trans('message.can_not_action')
                    ], 400);
                }
            } else {
                $acceptComment = news::find($lst['post_id']);

                if ($acceptComment->news_comment_status == 0) {
                    return response()->json([
                        'status' => false,
                        'code' => 400,
                        'message'=> trans('message.can_not_action')
                    ], 400);
                }
            }
            $comment = new comment;
            if ($lst['type_comment'] !== 'posts' && $lst['type_comment'] !== 'news') {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => trans('message.input_not_right')
                ], 400);
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
            $status = $comment->save();
            $thisUser = auth('api')->user();
            $comment->author = $thisUser;
            if($status != 1){
                $result = response()->json([
                      'status' => false,
                      'code' => 400,
                      'message'=> trans('message.add_unstatus'),
                      'data' => null
                ], 400);
            }else{
                $result = response()->json([
                      'status' => true,
                      'code' => 200,
                      'message'=> trans('message.add_status'),
                      'data' => $comment
                ], 200);
            }
            return $result;
        }
        return  response()->json([
            'status' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ], 400);
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
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
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
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => trans('message.input_not_right')
                ], 400);
            } else if ($lst['type_comment'] === 'posts') {
                $comments = comment::where('post_id', '=', $lst['post_id'])->where('comment_level', '=', 2)->where('comment_id', '=', $lst['comment_id'])->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                    $liker = account::where('id', '=', $comments[$i]->user_id)->first();
                    $comments[$i]->user_id = $liker;
                }
            } else {
                $comments = comment::where('news_id', '=', $lst['post_id'])->where('comment_level', '=', 2)->where('comment_id', '=', $lst['comment_id'])->limit($limit)->offset($offset)->get();
                for ($i = 0; $i < count($comments); $i++) {
                    $like = like_comment::where('id_comment', '=', $comments[$i]->id)->get();
                    $comments[$i]->count_like = count($like);
                    $liker = account::where('id', '=', $comments[$i]->user_id)->first();
                    $comments[$i]->user_id = $liker;
                }
            }
            $result = [
                'status' => true,
                'code' => 200,
                'data' => $comments
            ];
            return response()->json($result);
        }
        return  response()->json([
            'status' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ], 400);
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
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }
        if (array_key_exists('post_id', $lst) || $lst['type_comment'] !== null){
            $commented = comment::where('post_id', '=', $lst['post_id'])->where('id', '=', $id)->first();
            if (!$commented) {
                return response()->json([
                    'status' => false,
                    'code' => 404,
                    'message' => trans('message.not_found')
                ], 404);
            }
            $commented->comment_content = $lst['comment_content'];
            $status = $commented->save();
            if($status != 1){
                $result = response()->json([
                    'status' => false,
                    'code' => 400,
                    'message'=> trans('message.upate_unstatus'),
                    'data' => null
                ], 400);
            }else{
                $result = response()->json([
                    'status' => true,
                    'code' => 200,
                    'message'=> trans('message.upate_status'),
                    'data' => $commented
                ], 200);
            }
            return $result;
        }
        return  response()->json([
            'status' => false,
            'code' => 400,
            'message' => trans('message.please_fill_out_the_form')
        ], 400);
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
            return  response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ]. 401);
        }
        $comment = comment::find($id);
        if ($comment->user_id != $userId) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'message' => trans('message.can_not_action')
            ], 401);
        }
        if (!$comment) {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message'=> trans('message.not_found_item')
            ], 404);
        }
        $listCommentChildren = comment::where('comment_id', '=', $id)->get();
        for ($i = 0; $i < count($listCommentChildren); $i++) {
            $listCommentChildren[$i]->delete();
        }
        $comment->delete();
        return response()->json([
            'status' => true,
            'code' => 200,
            'message'=> trans('message.delete_status'),
            'data' => $comment
        ], 200);
    }
}
