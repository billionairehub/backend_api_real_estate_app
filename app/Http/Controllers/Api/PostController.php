<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Constants;
use Carbon\Carbon;
use Image;
use App\post;

class PostController extends Controller
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

            $now = Carbon::now();
            $photo_name = Carbon::parse($now)->format('YmdHis').'.jpg';
            $string = '';
            $count_img = count($_FILES['post_image']);
            for($i = 0 ; $i < $count_img ; $i++ )
            {
                $img_full_size = Image::make($request->file('post_image')->getRealPath())->filesize();
                if($img_full_size > 2000000 )
                {
                    $path_resize = $request->file('post_image')->storeAs('./img_post_resize/',$photo_name);
                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;
                    Storage::put($path_resize, $size);
                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);
                    $string = $string.$img_url_re;
                }
                else 
                {
                    $path = $request->file('post_image')->storeAs('./img_post/',$photo_name);//save img resize to image_avata
                    $path_resize = $request->file('post_image')->storeAs('./img_post/',$photo_name);
                    $img_url = asset('/storage/img_post/'.$photo_name);
                    $string = $string.$img_url;
                }
                if ($i < ($count_img - 1)) {
                    $string = $string . ',';
                }
            }
            $post->post_image = $string;
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
