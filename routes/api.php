<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('create-account',[
    'as'=>'create-account',
    'uses'=> 'Api\CreateAccountController@store'
]);

Route::post('login-account',[
	'as'=>'login-account',
    'uses'=> 'Api\LoginController@login'
]);

// Send mail
Route::post('send-code',[
    'as'=>'send-code',
    'uses'=> 'Api\MailServiceController@sendCode'
]);
// Check code
Route::post('check-code-email', [
    'as'=>'check-code-email',
    'uses'=>'Api\MailServiceController@checkCodeEmail'
]);
// Change password
Route::post('change-password', [
    'as'=>'change-password',
    'uses'=>'Api\MailServiceController@changePassword'
]);


Route::middleware(['assign.guard:api','jwt.auth'])->group(function(){
   Route::get('get-profile',[
    'as'=>'get-profile',
    'uses'=> 'Api\LoginController@getInfo'
    ]);
    Route::get('list-account',[
        'as'=>'list-account',
        'uses'=> 'Api\CreateAccountController@index'
    ]);
    Route::post('update-password',[
        'as'=>'update-account',
        'uses'=> 'Api\CreateAccountController@updatePassword'
    ]);
    Route::post('update-account',[
        'as'=>'update-account',
        'uses'=> 'Api\CreateAccountController@update'
    ]);
    Route::get('logout-account',[
        'as'=>'logout-account',
        'uses'=> 'Api\LoginController@logout'
    ]);
    
    Route::get('detail-profile/{id}',[
        'as'=>'detail-profile',
        'uses'=> 'Api\CreateAccountController@edit'
    ]);
    
    Route::get('list-album',[
        'as'=>'list-album',
        'uses'=> 'Api\LoginController@getAlbum'
    ]);
    // Get post
    Route::get('get-all-post', [
        'as'=>'get-all-post',
        'uses'=>'Api\PostController@index'
    ]);
    // Get a Post
    Route::get('post/{id}', [
        'as'=>'post',
        'uses'=>'Api\PostController@show'
    ]);
    // Get comments
    Route::post('list-comment', [
        'as'=>'list-comment',
        'uses'=>'Api\CommentServiceController@index'
    ]);
    // Get reply comments
    Route::post('list-reply-comment', [
        'as'=>'list-reply-comment',
        'uses'=>'Api\CommentServiceController@show'
    ]);
    
    Route::post('my-post', [
        'as'=>'my-post',
        'uses'=>'Api\PostController@mypost'
    ]);
    // Post //
    //create post
    Route::post('create-post', [
        'as'=>'create-post',
        'uses'=>'Api\PostController@create'
    ]);
    //Update post
    Route::post('update-post/{id}', [
        'as'=>'update-post',
        'uses'=>'Api\PostController@update'
    ]);
    //Delete post
    Route::post('delete-post/{id}', [
        'as'=>'delete-post',
        'uses'=>'Api\PostController@destroy'
    ]);
    // Like //
    // Add like
    Route::post('add-like', [
        'as'=>'add-like',
        'uses'=>'Api\LikeServiceController@like'
    ]);
    // Unlike
    Route::post('un-like', [
        'as'=>'un-like',
        'uses'=>'Api\LikeServiceController@unlike'
    ]);
    
    //list-like
    Route::post('list-like', [
        'as'=>'list-like',
        'uses'=>'Api\LikeServiceController@listlike'
    ]);	
    // Comment //
    // Add comment
    Route::post('add-comment', [
        'as'=>'add-comment',
        'uses'=>'Api\CommentServiceController@create'
    ]);
    // Update comment
    Route::post('update-comment/{id}', [
        'as'=>'update-comment',
        'uses'=>'Api\CommentServiceController@update'
    ]);
    // Delete comment
    Route::get('delete-comment/{id}', [
        'as'=>'delete-comment',
        'uses'=>'Api\CommentServiceController@destroy'
    ]);
    //================================//================================
    // Follow //
    // Get follow
    Route::post('list-followed', [
        'as'=>'list-followed',
        'uses'=>'Api\FollowServiceController@index'
    ]);
    // Add follow
    Route::post('add-follow', [
        'as'=>'add-follow',
        'uses'=>'Api\FollowServiceController@create'
    ]);
    // Delete follow
    Route::post('un-follow', [
        'as'=>'un-follow',
        'uses'=>'Api\FollowServiceController@destroy'
    ]);
    //================================//================================
    // News || Post in Home page //
    Route::post('get-all-project', [
        'as'=>'get-all-project',
        'uses'=>'Api\NewsServiceController@index'
    ]);
    Route::get('get-project/{id}', [
        'as'=>'get-project',
        'uses'=>'Api\NewsServiceController@show'
    ]);
    Route::post('my-project', [
        'as'=>'my-project',
        'uses'=>'Api\NewsServiceController@mynews'
    ]);
    Route::post('add-project', [
        'as'=>'add-project',
        'uses'=>'Api\NewsServiceController@create'
    ]);
    Route::post('edit-project/{id}', [
        'as'=>'edit-project',
        'uses'=>'Api\NewsServiceController@update'
    ]);
    Route::get('delete-project/{id}', [
        'as'=>'delete-project',
        'uses'=>'Api\NewsServiceController@destroy'
    ]);
    //================================//================================
    // Like comment
    Route::post('list-like-comment', [
        'as'=>'list-like-comment',
        'uses'=>'Api\LikeCommentServiceController@index'
    ]);
    // Add like comment
    Route::post('add-like-comment', [
        'as'=>'add-like-comment',
        'uses'=>'Api\LikeCommentServiceController@create'
    ]);
    // Unlike comment 
    Route::post('un-like-comment', [
        'as'=>'un-like-comment',
        'uses'=>'Api\LikeCommentServiceController@destroy'
    ]);
    // Search
    Route::get('search/result', [
        'as'=>'search/result',
        'uses'=>'Api\SearchServiceController@index'
    ]);
        //get-news
    Route::get('get-news', [
        'as'=>'get-news',
        'uses'=>'Api\NewsCrawlerController@index'
    ]);	
});
Route::get('create-symlink', function() {    Artisan::call('storage:link');});

