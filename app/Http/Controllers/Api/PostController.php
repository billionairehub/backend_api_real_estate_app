<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use Constants;

use Carbon\Carbon;

use Image;

use App\comment;

use App\like;

use App\post;

use App\account;



class PostController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    function generateRandomString($length = 10) {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }



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


        $offset = Constants::OFFSET;

        $limit = Constants::LIMIT;

        if ($request->offset != null) {

            $offset = $lst['offset'];

        }

        if ($request->limit !=  null) {

            $limit = $lst['limit'];

        }

        $posts = post::limit($limit)->offset($offset)->orderBy('id', 'DESC')->get();

        for ($i = 0; $i < count($posts); $i++) {

            $posts[$i]->post_image = explode(',', $posts[$i]->post_image);

            $author = account::find($posts[$i]->post_author);

            $posts[$i]->post_author = $author;

            $like = like::where('id_post','=', $posts[$i]->id)->get();

            $comment = comment::where('post_id','=', $posts[$i]->id)->get();

            $isliked = like::where('id_account_like', $userId)->where('id_post','=', $posts[$i]->id)->first();
            if (!$isliked) {
                $posts[$i]->is_liked = false;
            } else {
                $posts[$i]->is_liked = true;
            }

            $posts[$i]->count_like = count($like);

            $posts[$i]->count_comment = count($comment);

        }
        $result = [

            'status' => true,

            'code' => 200,

            'data' => $posts

        ];

        return response()->json($result, 200);

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

        if (array_key_exists('post_content', $lst) && $lst['post_content'] != null) {

            $lst = $request->all();

            $post = new post;

            $post->post_author = $userId;

            $post->post_content = $lst['post_content'];

            if (array_key_exists('post_image', $lst) && $lst['post_image'] != null) {
                $url = Storage::url('202009290607360LOCB6EYAFA.jpg');

                $string = '';

                $count_img = count($request->file('post_image'));

                for($i = 0 ; $i < $count_img ; $i++ )

                {

                    $generateName = $this->generateRandomString();

                    $now = Carbon::now();

                    $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                    $img_full_size = Image::make(($request->file('post_image')[$i])->getRealPath())->filesize();

                    if($img_full_size > 2000000 )

                    {

                        $path_resize = ($request->file('post_image')[$i])->storeAs('./img_post_resize/',$photo_name);

                        $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                        Storage::put($path_resize, $size);

                        $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                        $string = $string.$img_url_re;

                    }

                    else

                    {

                        $path = $request->file('post_image')[$i]->storeAs('./img_post/',$photo_name);//save img resize to image_avata

                        $path_resize = ($request->file('post_image')[$i])->storeAs('./img_post/',$photo_name);

                        $img_url = asset('/storage/img_post/'.$photo_name);

                        $string = $string.$img_url;

                    }

                    if ($i < ($count_img - 1)) {

                        $string = $string . ',';

                    }

                }



                $post->post_image = $string;
            }

            $post->post_status = Constants::STATUS_POST_PUBLISHED;

            $post->post_comment_status = Constants::STATUS_COMMENT_POST_UNBLOCK;

            if (array_key_exists('post_status', $lst)) {

                $post->post_status = $lst['post_status'];

            }

            if (array_key_exists('post_comment_status', $lst)) {

                $post->post_comment_status = $lst['post_comment_status'];

            }

            $success = $post->save();



            if($success != 1){

                $result = response()->json([

                      'status' => false,

                      'code' => 400,

                      'message'=> trans('message.add_unsuccess'),

                      'data' => null

                ], 400);

            }else{

                $post->post_image = explode(',', $post->post_image);

                $author = account::find($post->post_author);

                $post->post_author = $author;

                $isliked = like::where('id_account_like', $userId)->where('id_post','=', $post->id)->first();
                if (!$isliked) {
                    $post->is_liked = false;
                } else {
                    $post->is_liked = true;
                }

                $result = response()->json([

                      'status' => true,

                      'code' => 200,

                      'message'=> trans('message.add_success'),

                      'data' => $post

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

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $data = post::where('id', $id)->get();

        if (count($data) == 0) {

             return response()->json([

                'status' => false,

                'code' => 403,

                'message' => trans('message.not_found_item')

             ], 403);

        }

        $data[0]->post_image = explode(',', $data[0]->post_image);

        $like = like::where('id_post','=', $data[0]->id)->get();

        $comment = comment::where('post_id','=', $data[0]->id)->get();

        $data[0]->count_like = count($like);

        $data[0]->count_comment = count($comment);

        $author = account::find($data[0]->post_author);

        $data[0]->post_author = $author;

        

        $isliked = like::where('id_account_like', $userId)->where('id_post','=', $data[0]->id)->first();
        if (!$isliked) {
            $data[0]->is_liked = false;
        } else {
            $data[0]->is_liked = true;
        }

        return response()->json([

            'status' => true,

            'code' => 200,

            'message' => trans('message.success'),

            'data' => $data

        ], 200);

    }



    public function mypost(Request $request) {

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $offset = Constants::OFFSET;

        $limit = Constants::LIMIT;

        if ($request['offset'] != null) {

            $offset = $lst['offset'];

        }

        if ($request['limit'] !=  null) {

            $limit = $lst['limit'];

        }

        

        $post = post::where('post_author', '=', $userId)->limit($limit)->offset($offset)->orderBy('id', 'DESC')->get();

        for ($i = 0; $i < count($post); $i++) {

            $post[$i]->post_image  = explode(',', $post[$i]->post_image);

            $like = like::where('id_post','=', $post[$i]->id)->get();

            $comment = comment::where('post_id','=', $post[$i]->id)->get();
            

            $isliked = like::where('id_account_like', $userId)->where('id_post','=', $post[$i]->id)->first();
            if (!$isliked) {
                $post[$i]->is_liked = false;
            } else {
                $post[$i]->is_liked = true;
            }

            $post[$i]->count_like = count($like);

            $post[$i]->count_comment = count($comment);

        }

        for ($i = 0; $i < count($post); $i++) {

            $author = account::where('id', '=', $post[$i]->post_author)->first();

            $post[$i]->post_author = $author;

        }

        $result = [

            'status' => true,

            'code' => 200,

            'data' => $post

        ];

        return response()->json($result, 200);

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

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $lst = $request->all();

        $post = post::find($id);

        if ($post->post_author != $userId) {

            return response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.can_not_action')

            ], 401);

        }

        if (!$post) {

             return response()->json([

                'status' => false,

                'code' => 403,

                'message' => trans('message.not_found_item')

             ], 403);

        }

        if (array_key_exists('post_content', $lst)) {

            $post->post_content = $lst['post_content'];

        }

        if (array_key_exists('post_image', $lst)) {

            $string = '';

            $count_img = count($request->file('post_image'));

            for($i = 0 ; $i < $count_img ; $i++ )

            {

                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                $img_full_size = Image::make(($request->file('post_image')[$i])->getRealPath())->filesize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('post_image')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $string = $string.$img_url_re;

                }

                else

                {

                    $path = $request->file('post_image')[$i]->storeAs('./img_post/',$photo_name);//save img resize to image_avata

                    $path_resize = ($request->file('post_image')[$i])->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $string = $string.$img_url;

                }

                if ($i < ($count_img - 1)) {

                    $string = $string . ',';

                }

            }

            $post->post_image = $string;

        }

        $post->post_status = Constants::STATUS_POST_PUBLISHED;

        if (array_key_exists('post_status', $lst)) {

            $post->post_status = $lst['post_status'];

        }

        $post->post_comment_status = Constants::STATUS_COMMENT_POST_UNBLOCK;

        if (array_key_exists('post_comment_status', $lst)) {

            $post->post_comment_status = $lst['post_comment_status'];

        }

        $newdata = $post->save();

        if($newdata != 1){

            $result = response()->json([

                  'status' => false,

                  'code' => 400,

                  'message'=> trans('message.upate_unsuccess'),

                  'data' => null

            ], 400);

        }else{

            $post->post_image = explode(',', $post->post_image);
            

            $isliked = like::where('id_account_like', $userId)->where('id_post','=', $post->id)->first();
            if (!$isliked) {
                $post->is_liked = false;
            } else {
                $post->is_liked = true;
            }

            $result = response()->json([

                  'status' => true,

                  'code' => 200,

                  'message'=> trans('message.upate_success'),

                  'data' => $post

            ], 200);

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

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $post = post::find($id);

        if ($post->post_author != $userId) {

            return response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.can_not_action')

            ], 401);

        }

        if (!$post) {

            return response()->json([

                'status' => false,

                'code' => 403,

                'message'=> trans('message.not_found_item')

            ], 403);

        }
        $comment = comment::where('post_id', '=', $id)->get();
        for ($i = 0; $i < count($comment); $i++) {
            $comment[$i]->delete();
        }
        $like = like::where('id_post', '=', $id)->get();
        for ($j = 0; $j < count($like); $j++) {
            $like[$j]->delete();
        }
        $post->delete();

        $post->post_image = explode(',', $post->post_image);

        return response()->json([

            'status' => true,

            'code' => 200,

            'message'=> trans('message.delete_success'),

            'data' => $post

        ], 200);

    }

}

