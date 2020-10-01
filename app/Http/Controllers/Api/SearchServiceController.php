<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Constants;
use App\news;
use App\account;
use DB;

class SearchServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lst = $_GET;
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
        if (array_key_exists('offset', $lst) && $lst['offset'] != null) {
            $offset = $lst['offset'];
        }
        if (array_key_exists('limit', $lst) && $lst['limit'] !=  null) {
            $limit = $lst['limit'];
        }
        $result = news::query();
        if ((array_key_exists('lowest-price', $lst) && $lst['lowest-price'] != null) && (array_key_exists('highest-price', $lst) && $lst['highest-price'] != null)) {
            return [
                'success' => false,
                'code' => 401,
                'message' => trans('message.input_not_right')
            ];
        }
        // District, province, lowest-price
        if ((array_key_exists('provincials', $lst) && $lst['provincials'] != null) && (array_key_exists('district', $lst) && $lst['district'] != null) && (array_key_exists('lowest-price', $lst) && $lst['lowest-price'] != null)) {
            $result = $result->where('news_province', 'like', '%'.$lst['provincials'].'%')->where('news_district', 'like', '%'.$lst['district'].'%')->orderBy('news_price_to')->limit($limit)->offset($offset)->get();
        }
        // District, province, highest-price
        else if ((array_key_exists('provincials', $lst) && $lst['provincials'] != null) && (array_key_exists('district', $lst) && $lst['district'] != null) && (array_key_exists('highest-price', $lst) && $lst['highest-price'] != null)) {
            $result = $result->where('news_province', 'like', '%'.$lst['provincials'].'%')->where('news_district', 'like', '%'.$lst['district'].'%')->orderBy('news_price_to', 'desc')->limit($limit)->offset($offset)->get();
        }
        // District, highest-price
        else if ((array_key_exists('district', $lst) && $lst['district'] != null) && (array_key_exists('highest-price', $lst) && $lst['highest-price'] != null)) {
            $result = $result->where('news_district', 'like', '%'.$lst['district'].'%')->orderBy('news_price_to', 'desc')->limit($limit)->offset($offset)->get();
        }
        // District, lowest-price
        else if ((array_key_exists('district', $lst) && $lst['district'] != null) && (array_key_exists('lowest-price', $lst) && $lst['lowest-price'] != null)) {
            $result = $result->where('news_district', 'like', '%'.$lst['district'].'%')->orderBy('news_price_to')->limit($limit)->offset($offset)->get();
        }
        // Province, highest-price
        else if ((array_key_exists('provincials', $lst) && $lst['provincials'] != null) && (array_key_exists('highest-price', $lst) && $lst['highest-price'] != null)) {
            $result = $result->where('news_province', 'like', '%'.$lst['provincials'].'%')->orderBy('news_price_to', 'desc')->limit($limit)->offset($offset)->get();
        }
        // Province, lowest-price
        else if ((array_key_exists('provincials', $lst) && $lst['provincials'] != null) && (array_key_exists('lowest-price', $lst) && $lst['lowest-price'] != null)) {
            $result = $result->where('news_province', 'like', '%'.$lst['provincials'].'%')->orderBy('news_price_to')->limit($limit)->offset($offset)->get();
        }
        // Else 
        else {
            if (array_key_exists('provincials', $lst) && $lst['provincials'] != null) {
                $result = $result->where('news_province', 'like', '%'.$lst['provincials'].'%')->limit($limit)->offset($offset)->get();
            }
            if (array_key_exists('district', $lst) && $lst['district'] != null) {
                $result = $result->where('news_district', 'like', '%'.$lst['district'].'%')->limit($limit)->offset($offset)->get();
            }
            if (array_key_exists('lowest-price', $lst) && $lst['lowest-price'] != null) {
                $result = $result->orderBy('news_price_to')->limit($limit)->offset($offset)->get();
            }
            if (array_key_exists('highest-price', $lst) && $lst['highest-price'] != null) {
                $result = $result->orderBy('news_price_to', 'desc')->limit($limit)->offset($offset)->get();
            }
        }
        if (count($lst) == 0) {
            $result = news::orderBy('created_at', 'desc')->limit($limit)->offset($offset)->get();
        }
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->news_feature_image  = explode(',', $result[$i]->news_feature_image);
        }
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->news_image  = explode(',', $result[$i]->news_image);
        }
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->news_logo  = explode(',', $result[$i]->news_logo);
        }
        for ($i = 0; $i < count($result); $i++) {
            $author = account::where('id', '=', $result[$i]->news_author)->first();
            $result[$i]->news_author = $author;
        }
        return [
            'success' => true,
            'code' => 200,
            'message'=> trans('message.status_pass'),
            'data' => $result
        ];
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
}
