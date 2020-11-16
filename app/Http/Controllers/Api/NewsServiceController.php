<?php



namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use Constants;

use Carbon\Carbon;

use Image;

use App\news;

use App\account;

use App\comment;

use App\like;



class NewsServiceController extends Controller

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

        $lst = $request->all();

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

        $news = news::limit($limit)->offset($offset)->orderBy('id', 'DESC')->get();

        for ($i = 0; $i < count($news); $i++) {

            $news[$i]->news_feature_image  = explode(',', $news[$i]->news_feature_image);

        }

        for ($i = 0; $i < count($news); $i++) {

            $news[$i]->news_image  = explode(',', $news[$i]->news_image);

        }

        for ($i = 0; $i < count($news); $i++) {

            $news[$i]->news_logo  = explode(',', $news[$i]->news_logo);

        }

        for ($i = 0; $i < count($news); $i++) {

            $author = account::where('id', '=', $news[$i]->news_author)->first();

            $news[$i]->news_author = $author;

            $isliked = like::where('id_account_like', $userId)->where('id_news','=', $news[$i]->id)->first();

            $like = like::where('id_news','=', $news[$i]->id)->get();

            $comment = comment::where('news_id','=', $news[$i]->id)->get();
            if (!$isliked) {
                $news[$i]->is_liked = false;
            } else {
                $news[$i]->is_liked = true;
            }
            $news[$i]->is_liked = count($like);

            $news[$i]->count_like = count($like);

            $news[$i]->count_comment = count($comment);

        }

        $result = [

            'status' => true,

            'code' => 200,

            'message' => trans('message.status_pass'),

            'data' => $news

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
        try {
            $lst = $request->all();

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $news = new news;

        $news->news_title = $lst['news_title'];

        $news->news_description = $lst['news_description'];

        $news->news_author = $userId;

        $news->news_type = $lst['news_type'];

        $news->news_price_from = $lst['news_price_from'];

        if (array_key_exists('news_price_to', $lst) && $lst['news_price_to'] != null) {

            $news->news_price_to = $lst['news_price_to'];

        }

        $news->news_price_meters_from = $lst['news_price_meters_from'];

        if (array_key_exists('news_price_meters_to', $lst) && $lst['news_price_meters_to'] != null) {

            $news->news_price_meters_to = $lst['news_price_meters_to'];

        }

        $news->news_investment = $lst['news_investment'];

        $news->news_building_density = $lst['news_building_density'];

        $news->news_land_area = $lst['news_land_area'];

        if (array_key_exists('news_lng', $lst) && $lst['news_lng'] != null) 
        {
            $news->lng = $lst['news_lng'];
        }
        
        
        if (array_key_exists('news_lat', $lst) && $lst['news_lat'] != null) 
        {
            $news->lat = $lst['news_lat'];
        }
        

        if (array_key_exists('news_project', $lst) && $lst['news_project'] != null) {

            $news->news_project = $lst['news_project'];

        }

        if (array_key_exists('news_street', $lst) && $lst['news_street'] != null) {

            $news->news_street = $lst['news_street'];

        }

        if (array_key_exists('news_district', $lst) && $lst['news_district'] != null) {

            $news->news_district = $lst['news_district'];

        }

        if (array_key_exists('news_ward', $lst) && $lst['news_ward'] != null) {

            $news->news_ward = $lst['news_ward'];

        }

        if (array_key_exists('news_province', $lst) && $lst['news_province'] != null) {

            $news->news_province = $lst['news_province'];

        }

        if (array_key_exists('news_image', $lst) && $lst['news_image'] != null) {

            $string = '';

            $count_img = count($request->file('news_image'));


            for($i = 0 ; $i < $count_img ; $i++ )

            {
                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';
                

                $img_full_size = $request->file('news_image')[$i]->getSize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('news_image')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $string = $string.$img_url_re;

                }

                else

                {

                    $path = $request->file('news_image')[$i]->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $string = $string.$img_url;

                }

                if ($i < ($count_img - 1)) {

                    $string = $string . ',';

                }

            }

            $news->news_image = $string;

        }


        if (array_key_exists('news_feature_image', $lst) && $lst['news_feature_image'] != null)
        {
            $news_feature_image = '';


            $count_img_feature = count($request->file('news_feature_image'));

            for($i = 0 ; $i < $count_img_feature ; $i++ )

            {

                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                $img_full_size = $request->file('news_feature_image')[$i]->getSize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('news_feature_image')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $news_feature_image = $news_feature_image.$img_url_re;

                }

                else

                {

                    $path = $request->file('news_feature_image')[$i]->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $news_feature_image = $news_feature_image.$img_url;

                }

                if ($i < ($count_img_feature - 1)) {

                    $news_feature_image = $news_feature_image . ',';

                }

            }

            $news->news_feature_image = $news_feature_image;
        }
        
        if (array_key_exists('news_logo', $lst) && $lst['news_logo'] != null)
        {
            $news_logo = '';

            $count_img_logo = count($request->file('news_logo'));

            for($i = 0 ; $i < $count_img_logo ; $i++ )

            {

                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                $img_full_size = $request->file('news_logo')[$i]->getSize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('news_logo')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $news_logo = $news_logo.$img_url_re;

                }

                else

                {

                    $path = $request->file('news_logo')[$i]->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $news_logo = $news_logo.$img_url;

                }

                if ($i < ($count_img_logo - 1)) {

                    $news_logo = $news_logo . ',';

                }

            }

            $news->news_logo = $news_logo;
        }

       

        

        $news->news_status = Constants::STATUS_POST_PUBLISHED;

        $news->news_comment_status = Constants::STATUS_COMMENT_POST_UNBLOCK;

        if (array_key_exists('post_status', $lst)) {

            $news->news_status = $lst['news_status'];

        }

        if (array_key_exists('post_comment_status', $lst)) {

            $news->news_comment_status = $lst['news_comment_status'];

        }


        $success = $news->save();
        

        if($success != 1){

            $result = response()->json([

                    'status' => false,

                    'code' => 400,

                    'message'=> trans('message.add_unsuccess'),

                    'data' => null

            ] , 400);

        }else{
            $news->news_feature_image  = explode(',', $news->news_feature_image);
            $news->news_image  = explode(',', $news->news_image);
            $news->news_logo  = explode(',', $news->news_logo);
            $author = account::where('id', '=', $news->news_author)->first();
            $news->is_liked = false;

            $result = response()->json([

                    'status' => true,

                    'code' => 200,

                    'message'=> trans('message.add_success'),

                    'data' => $news

            ]);

        }

        return $result;
        } catch (Throwable $e) {
            return response()->json([

                'status' => false,

                'code' => 400,

                'message'=> trans('message.server_error'),

                'data' => $news

            ], 400);
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

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $news = news::where('id', '=', $id)->first();

        $news->news_feature_image  = explode(',', $news->news_feature_image);

        $news->news_image  = explode(',', $news->news_image);

        $news->news_logo  = explode(',', $news->news_logo);

        $author = account::where('id', '=', $news->news_author)->first();

        $news->news_author = $author;

        

        $like = like::where('id_news','=', $news->id)->get();

        $comment = comment::where('news_id','=', $news->id)->get();

        $news->count_like = count($like);

        $news->count_comment = count($comment);

        $isliked = like::where('id_account_like', $userId)->where('id_news','=', $news->id)->first();
        if (!$isliked) {
            $news->is_liked = false;
        } else {
            $news->is_liked = true;
        }



        $result = response()->json([

            'status' => true,

            'code' => 200,

            'data' => $news

        ], 200);

        return $result;

    }



    public function mynews(Request $request) {

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
        $lst = $request->all();

        if ($request['offset'] != null) {

            $offset = $lst['offset'];

        }

        if ($request['limit'] !=  null) {

            $limit = $lst['limit'];

        }

        $news = news::where('news_author', '=', $userId)->limit($limit)->offset($offset)->get();

        for ($i = 0; $i < count($news); $i++) {

            $news[$i]->news_feature_image  = explode(',', $news[$i]->news_feature_image);

        }

        for ($i = 0; $i < count($news); $i++) {

            $news[$i]->news_image  = explode(',', $news[$i]->news_image);

        }

        for ($i = 0; $i < count($news); $i++) {

            $news[$i]->news_logo  = explode(',', $news[$i]->news_logo);

        }

        for ($i = 0; $i < count($news); $i++) {

            $author = account::where('id', '=', $news[$i]->news_author)->first();

            $news[$i]->news_author = $author;



            $like = like::where('id_news','=', $news[$i]->id)->get();

            $comment = comment::where('news_id','=', $news[$i]->id)->get();

            $news[$i]->count_like = count($like);

            $news[$i]->count_comment = count($comment);

            $isliked = like::where('id_account_like', $userId)->where('id_news','=', $news[$i]->id)->first();
            if (!$isliked) {
                $news[$i]->is_liked = false;
            } else {
                $news[$i]->is_liked = true;
            }

        }

        $result = [

            'status' => true,

            'code' => 200,

            'message' => trans('message.get_list_success'),

            'data' => $news

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

        $lst = $request->all();

        $userId = auth('api')->user()->id;

        if (!$userId) {

            return  response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);

        }

        $news = news::find($id);

        if ($news->news_author !== $userId) {

            return response()->json([

                'status' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

            ], 401);

        }

        if (array_key_exists('news_title', $lst) && $lst['news_title'] != null) {

            $news->news_title = $lst['news_title'];

        }

        if (array_key_exists('news_description', $lst) && $lst['news_description'] != null) {

            $news->news_description = $lst['news_description'];

        }

        if (array_key_exists('news_type', $lst) && $lst['news_type'] != null) {

            $news->news_type = $lst['news_type'];

        }

        if (array_key_exists('news_price_from', $lst) && $lst['news_price_from'] != null) {

            $news->news_price_from = $lst['news_price_from'];

        }

        if (array_key_exists('news_price_to', $lst) && $lst['news_price_to'] != null) {

            $news->news_price_to = $lst['news_price_to'];

        }

        if (array_key_exists('news_price_meters_from', $lst) && $lst['news_price_meters_from'] != null) {

            $news->news_price_meters_from = $lst['news_price_meters_from'];

        }

        if (array_key_exists('news_price_meters_to', $lst) && $lst['news_price_meters_to'] != null) {

            $news->news_price_meters_to = $lst['news_price_meters_to'];

        }

        if (array_key_exists('news_investment', $lst) && $lst['news_investment'] != null) {

            $news->news_investment = $lst['news_investment'];

        }

        if (array_key_exists('news_lng', $lst) && $lst['news_lng'] != null) {

            $news->lng = $lst['news_lng'];

        }

        if (array_key_exists('news_lat', $lst) && $lst['news_lat'] != null) {

            $news->lat = $lst['news_lat'];

        }

        if (array_key_exists('news_building_density', $lst) && $lst['news_building_density'] != null) {

            $news->news_building_density = $lst['news_building_density'];

        }

        if (array_key_exists('news_land_area', $lst) && $lst['news_land_area'] != null) {

            $news->news_land_area = $lst['news_land_area'];

        }

        if (array_key_exists('news_project', $lst) && $lst['news_project'] != null) {

            $news->news_project = $lst['news_project'];

        }

        if (array_key_exists('news_street', $lst) && $lst['news_street'] != null) {

            $news->news_street = $lst['news_street'];

        }

        if (array_key_exists('news_district', $lst) && $lst['news_district'] != null) {

            $news->news_district = $lst['news_district'];

        }

        if (array_key_exists('news_ward', $lst) && $lst['news_ward'] != null) {

            $news->news_ward = $lst['news_ward'];

        }

        if (array_key_exists('news_province', $lst) && $lst['news_province'] != null) {

            $news->news_province = $lst['news_province'];

        }

        if (array_key_exists('news_image', $lst) && $lst['news_image'] != null) {

            $string = '';

            $count_img = count($request->file('news_image'));

            for($i = 0 ; $i < $count_img ; $i++ )

            {

                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                $img_full_size = Image::make(($request->file('news_image')[$i])->getRealPath())->filesize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('news_image')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $string = $string.$img_url_re;

                }

                else

                {

                    $path = $request->file('news_image')[$i]->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $string = $string.$img_url;

                }

                if ($i < ($count_img - 1)) {

                    $string = $string . ',';

                }

            }

            $news->news_image = $string;

        }

        if (array_key_exists('news_feature_image', $lst) && $lst['news_feature_image'] != null) {

            $news_feature_image = '';

            $count_img = count($request->file('news_feature_image'));

            for($i = 0 ; $i < $count_img ; $i++ )

            {

                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                $img_full_size = Image::make(($request->file('news_feature_image')[$i])->getRealPath())->filesize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('news_feature_image')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $news_feature_image = $news_feature_image.$img_url_re;

                }

                else

                {

                    $path = $request->file('news_feature_image')[$i]->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $news_feature_image = $news_feature_image.$img_url;

                }

                if ($i < ($count_img - 1)) {

                    $news_feature_image = $news_feature_image . ',';

                }

            }

            $news->news_feature_image = $news_feature_image;

        }

        if (array_key_exists('news_logo', $lst) && $lst['news_logo'] != null) {

            $news_logo = '';

            $count_img = count($request->file('news_logo'));

            for($i = 0 ; $i < $count_img ; $i++ )

            {

                $generateName = $this->generateRandomString();

                $now = Carbon::now();

                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';

                $img_full_size = Image::make(($request->file('news_logo')[$i])->getRealPath())->filesize();

                if($img_full_size > 2000000 )

                {

                    $path_resize = ($request->file('news_logo')[$i])->storeAs('./img_post_resize/',$photo_name);

                    $size =  Image::make(Storage::get($path_resize))->resize(750,512)->encode();;

                    Storage::put($path_resize, $size);

                    $img_url_re = asset('/storage/img_post_resize/'.$photo_name);

                    $news_logo = $news_logo.$img_url_re;

                }

                else

                {

                    $path = $request->file('news_logo')[$i]->storeAs('./img_post/',$photo_name);

                    $img_url = asset('/storage/img_post/'.$photo_name);

                    $news_logo = $news_logo.$img_url;

                }

                if ($i < ($count_img - 1)) {

                    $news_logo = $news_logo . ',';

                }

            }

            $news->news_logo = $news_logo;

        }

        if (array_key_exists('news_status', $lst) && $lst['news_status'] != null) {

            $news->news_status = $lst['news_status'];

        }

        if (array_key_exists('news_comment_status', $lst) && $lst['news_comment_status'] != null) {

            $news->news_comment_status = $lst['news_comment_status'];

        }

        $success = $news->save();

        if($success != 1){

            $result = response()->json([

                  'status' => false,

                  'code' => 400,

                  'message'=> trans('message.upate_unsuccess'),

                  'data' => null

            ], 400);

        }else{

            $news->news_feature_image  = explode(',', $news->news_feature_image);

            $news->news_image  = explode(',', $news->news_image);

            $news->news_logo  = explode(',', $news->news_logo);

            $author = account::where('id', '=', $news->news_author)->first();
            $isliked = like::where('id_account_like', $userId)->where('id_news','=', $news->id)->first();
            if (!$isliked) {
                $news->is_liked = false;
            } else {
                $news->is_liked = true;
            }

            $result = response()->json([

                  'status' => true,

                  'code' => 200,

                  'message'=> trans('message.upate_success'),

                  'data' => $news

            ], 200);

        }

        return $result;

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
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ], 401);
        }

        $news = news::find($id);
        if (!$news) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message'=> trans('message.not_found_item')
            ], 403);
        }

        if ($news->news_author !== $userId) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => trans('message.can_not_action')
            ], 401);
        }

        $comment = comment::where('news_id', '=', $id)->get();
        for ($i = 0; $i < count($comment); $i++) {
            $comment[$i]->delete();
        }
        $like = like::where('id_news', '=', $id)->get();
        for ($j = 0; $j < count($like); $j++) {
            $like[$j]->delete();
        }
        $news->delete();
        return [
            'success' => true,
            'code' => 200,
            'message'=> trans('message.delete_success')
        ];
    }

}

