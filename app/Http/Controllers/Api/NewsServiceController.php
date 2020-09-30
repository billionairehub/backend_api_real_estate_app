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
        $news = news::limit($limit)->offset($offset)->get();
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
        }
        $result = [
            'success' => true,
            'code' => 200,
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
        $lst = $request->all();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $news = new news;
        $news->news_title = $lst['news_title'];
        $news->news_description = $lst['news_description'];
        $news->news_author = $userId;
        $news->news_type = $lst['news_type'];
        $news->news_price = $lst['news_price'];
        $news->news_price_meters = $lst['news_price_meters'];
        $news->news_investment = $lst['news_investment'];
        $news->news_building_density = $lst['news_building_density'];
        $news->news_land_area = $lst['news_land_area'];
        if ($lst['news_project'] != null) {
            $news->news_project = $lst['news_project'];
        }
        if ($lst['news_street'] != null) {
            $news->news_street = $lst['news_street'];
        }
        if ($lst['news_district'] != null) {
            $news->news_district = $lst['news_district'];
        }
        if ($lst['news_ward'] != null) {
            $news->news_ward = $lst['news_ward'];
        }
        if ($lst['news_province'] != null) {
            $news->news_province = $lst['news_province'];
        }

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
                    'data' => $news
            ];
        }
        return response()->json($result);
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
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $news = news::where('id', '=', $id)->first();
        $news->news_feature_image  = explode(',', $news->news_feature_image);
        $news->news_image  = explode(',', $news->news_image);
        $news->news_logo  = explode(',', $news->news_logo);
        $author = account::where('id', '=', $news->news_author)->first();
        $news->news_author = $author;
        $result = [
            'success' => true,
            'code' => 200,
            'data' => $news
        ];
        return response()->json($result);
    }

    public function mynews(Request $request) {
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
        }
        $result = [
            'success' => true,
            'code' => 200,
            'data' => $news
        ];
        return response()->json($result);
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
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $news = news::find($id);
        if ($news->news_author !== $userId) {
            return [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
            ];
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
        if (array_key_exists('news_price', $lst) && $lst['news_price'] != null) {
            $news->news_price = $lst['news_price'];
        }
        if (array_key_exists('news_price_meters', $lst) && $lst['news_price_meters'] != null) {
            $news->news_price_meters = $lst['news_price_meters'];
        }
        if (array_key_exists('news_investment', $lst) && $lst['news_investment'] != null) {
            $news->news_investment = $lst['news_investment'];
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
            $result = [
                  'success' => false,
                  'code' => 400,
                  'message'=> trans('message.upate_unsuccess'),
                  'data' => null
            ];
        }else{
            $news->news_feature_image  = explode(',', $news->news_feature_image);
            $news->news_image  = explode(',', $news->news_image);
            $news->news_logo  = explode(',', $news->news_logo);
            $author = account::where('id', '=', $news->news_author)->first();
            $result = [
                  'success' => true,
                  'code' => 200,
                  'message'=> trans('message.upate_success'),
                  'data' => $news
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
        $lst = $request->all();
        $key = collect($request->all())->keys();
        $userId = auth('api')->user()->id;
        if (!$userId) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $news = news::find($id);
        if (!$news) {
            return [
                'success' => false,
                'code' => 403,
                'message'=> trans('message.not_found_item')
            ];
        }
        if ($news->news_author !== $userId) {
            return [
                'success' => false,
                'code' => 401,
                'message' => trans('message.can_not_action')
            ];
        }
        $comment = comment::where('news_id', '=', $id)->get();
        for ($i = 0; $i < count($comment); $i++) {
            $comment[$i]->delete();
        }
        $like = comment::where('id_news', '=', $id)->get();
        for ($j = 0; $j < count($like); $j++) {
            $like[$j]->delete();
        }
        $news->delete();
        return [
            'success' => true,
            'code' => 200,
            'message'=> trans('message.delete_success'),
            'data' => $news
        ];
    }
}
