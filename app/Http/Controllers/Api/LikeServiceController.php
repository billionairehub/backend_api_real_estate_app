<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Constants;

use DB;

use App\like;

use App\account;

use App\comment;

use App\news;

use App\post;



class LikeServiceController extends Controller

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

        if (array_key_exists('post_id', $lst) && $lst['post_id'] != null) {

            $offset = Constants::OFFSET;

            $limit = Constants::LIMIT;

            if ($request['offset'] != null) {

                $offset = $lst['offset'];

            }

            if ($request['limit'] !=  null) {

                $limit = $lst['limit'];

            }

            $like = like::where('id_post', '=', $lst['post_id'])->limit($limit)->offset($offset)->get();

            for ($i = 0; $i < count($like); $i++) {

                $user = account::where('id', '=',  $like[$i]->id_account_like)->first();

                $like[$i]->id_account_like = $user;

            }

            return response()->json([

                'status' => true,

                'code' => 200,

                'message' => trans('message.status_pass'),

                'data' => $like

            ], 200);

        }

        return response()->json([

            'status' => false,

            'code' => 401,

            'message' => trans('message.not_found_item')

        ], 401);

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

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        if (array_key_exists('post_id', $lst) && $lst['post_id'] !== null && array_key_exists('type_like', $lst) && $lst['type_like'] !== null){

            if ($lst['type_like'] == 'posts') {
                $posts = post::where('id', $lst['post_id'])->first();
                if (!$posts) {
                    return response()->json([

                        'status' => false,

                        'code' => 404,

                        'message' => trans('message.not_found_item')

                    ], 404);
                }
                $liked = like::where('id_post', '=' , $lst['post_id'])->where('id_account_like', '=', $userId)->first();
            } else if ($lst['type_like'] == 'news') {
                $news = news::where('id', $lst['post_id'])->first();
                if (!$news) {
                    return response()->json([

                        'status' => false,

                        'code' => 404,

                        'message' => trans('message.not_found_item')

                    ], 404);
                }
                $liked = like::where('id_news', '=' , $lst['post_id'])->where('id_account_like', '=', $userId)->first();
            } else {
                return response()->json([

                    'status' => false,

                    'code' => 400,

                    'message' => trans('message.input_not_right')

                ], 400);
            }


            if ($liked) {

                return response()->json([

                    'status' => false,

                    'code' => 400,

                    'message' => trans('message.delete_like')

                ], 400);

            }

            $like = new like;

            if ($lst['type_like'] !== 'posts' && $lst['type_like'] !== 'news') {

                return response()->json([

                    'status' => false,

                    'code' => 401,

                    'message' => trans('message.input_not_right')

                ], 401);

            } else if ($lst['type_like'] == 'posts') {

                $like->id_post = $lst['post_id'];

            } else {

                $like->id_news = $lst['post_id'];

            }

            $like->id_account_like = $userId;

            

            $success = $like->save();



            if($success != 1){

                $result = response()->json([

                    'status' => false,

                    'code' => 400,

                    'message'=> trans('message.add_unsuccess'),

                    'data' => null

                ], 400);

            } else {

                $result = response()->json([

                    'status' => true,

                    'code' => 200,

                    'message'=> trans('message.add_success'),

                    'data' => $like

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



    public function unlike (Request $request) {

        $userId = auth('api')->user()->id;

        $lst = $request->all();

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        if (array_key_exists('post_id', $lst) && $lst['post_id'] !== null && array_key_exists('type_like', $lst) && $lst['type_like'] !== null){

            if ($lst['type_like'] === 'posts') {
                $posts = post::where('id', $lst['post_id'])->first();
                if (!$posts) {
                    return response()->json([

                        'status' => false,

                        'code' => 404,

                        'message' => trans('message.not_found_item')

                    ], 404);
                }
                $liked = like::where('id_post', '=' , $lst['post_id'])->where('id_account_like', '=', $userId)->first();

            } else if ($lst['type_like'] == 'news') {
                $news = news::where('id', $lst['post_id'])->first();
                if (!$news) {
                    return response()->json([

                        'status' => false,

                        'code' => 404,

                        'message' => trans('message.not_found_item')

                    ], 404);
                }
                $liked = like::where('id_news', '=' , $lst['post_id'])->where('id_account_like', '=', $userId)->first();
            } else {
                return response()->json([

                    'status' => false,

                    'code' => 400,

                    'message' => trans('message.input_not_right')

                ], 400);
            }

            if (!$liked) {

                return response()->json([

                    'status' => false,

                    'code' => 401,

                    'message' => trans('message.can_not_action')

                ], 401);

            }

            $liked->delete();

            return response()->json([

                'status' => true,

                'code' => 200,

                'message'=> trans('message.delete_success'),

                'data' => $liked

            ], 200);

        }

        return  response()->json([

            'status' => false,

            'code' => 400,

            'message' => trans('message.please_fill_out_the_form')

        ], 400);

    }
    

    public function listlike (Request $request) {
        $lst = $request->all();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        if (array_key_exists('post_id', $lst) && $lst['post_id'] !== null && array_key_exists('type_like', $lst) && $lst['type_like'] !== null){

            if ($lst['type_like'] == 'posts') {
                $posts = post::where('id', $lst['post_id'])->first();
                if (!$posts) {
                    return response()->json([

                        'status' => false,

                        'code' => 404,

                        'message' => trans('message.not_found_item')

                    ], 404);
                }
                $liked = like::where('id_post', '=' , $lst['post_id'])->get();
            } else if ($lst['type_like'] == 'news') {
                $news = news::where('id', $lst['post_id'])->first();
                if (!$news) {
                    return response()->json([

                        'status' => false,

                        'code' => 404,

                        'message' => trans('message.not_found_item')

                    ], 404);
                }
                $liked = like::where('id_news', '=' , $lst['post_id'])->get();
            } else {
                return response()->json([

                    'status' => false,

                    'code' => 400,

                    'message' => trans('message.input_not_right')

                ], 400);
            }
            for ($i = 0; $i < count($liked); $i++) {
                $liker = account::where('id', '=', $liked[$i]->id_account_like)->first();
                $liked[$i]->id_account_like = $liker;
                $liked[$i]->user_id = $liker;
            }
            $result = response()->json([

                'status' => true,

                'code' => 200,

                'message' => trans('message.get_list_success'),

                'data' => $liked

            ], 200);

            return $result;

        }

        return  response()->json([

            'status' => false,

            'code' => 400,

            'message' => trans('message.please_fill_out_the_form')

        ], 400);
    }

}

