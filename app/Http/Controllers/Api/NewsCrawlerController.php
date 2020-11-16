<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Constants;
use App\news_crawler;
use App\category_crawler;

class NewsCrawlerController extends Controller
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
        if ($request->offset != null) {
            $offset = $lst['offset'];
        }
        if ($request->limit !=  null) {
            $limit = $lst['limit'];
        }
        $posts = news_crawler::join('category_crawler','news_crawler.category_id','=','category_crawler.id')->limit($limit)->offset($offset)->get();
        $result = response()->json([
            'status' => true,
            'code' => 200,
            'data' => $posts
        ], 200);
        return $result;
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
