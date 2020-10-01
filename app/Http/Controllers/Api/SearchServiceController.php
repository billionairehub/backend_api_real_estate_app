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
        // District, province, highest-price
        // District, highest-price
        // District, lowest-price
        // Province, highest-price
        // Province, lowest-price
        // if () {}
        // else if () {}
        // else if () {}
        // else {}
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
        // $result = news::where()->limit($limit)->offset($offset)->get();
        // $result = 'select * from news where ' . $query;
        dd($result);
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
