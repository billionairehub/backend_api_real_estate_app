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
 
Route::get('list-account',[
    'as'=>'list-account',
    'uses'=> 'Api\CreateAccountController@index'
]);
Route::post('list-account',[
    'as'=>'list-account',
    'uses'=> 'Api\CreateAccountController@store'
]);
Route::get('list-account/{id}',[
    'as'=>'list-account',
    'uses'=> 'Api\CreateAccountController@edit'
]);
Route::post('update-account/{id}',[
    'as'=>'update-account',
    'uses'=> 'Api\CreateAccountController@update'
]);

Route::post('login-account',[
	'as'=>'login-account',
    'uses'=> 'Api\LoginController@login'
]);

Route::get('logout-account',[
    'as'=>'logout-account',
    'uses'=> 'Api\LoginController@logout'
]);

Route::get('list-album/{id}',[
    'as'=>'list-album',
    'uses'=> 'Api\LoginController@getAlbum'
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

// Get post
Route::get('post', [
    'as'=>'post',
    'uses'=>'Api\PostController@index'
]);
// Get a Post
Route::get('post/{id}', [
    'as'=>'post',
    'uses'=>'Api\PostController@show'
]);
// Get comments
Route::post('comment', [
    'as'=>'comment',
    'uses'=>'Api\CommentServiceController@index'
]);
// Get reply comments
Route::post('recomment', [
    'as'=>'comment',
    'uses'=>'Api\CommentServiceController@show'
]);

Route::middleware(['assign.guard:api','jwt.auth'])->group(function(){
   Route::get('get-info-account',[
    'as'=>'get-info-account',
    'uses'=> 'Api\LoginController@getInfo'
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
    // Comment //
    // Add comment
    Route::post('add-comment', [
        'as'=>'add-comment',
        'uses'=>'Api\CommentServiceController@create'
    ]);
    // Update comment
    Route::post('update-comment', [
        'as'=>'update-comment',
        'uses'=>'Api\CommentServiceController@update'
    ]);
    // Delete comment
    Route::get('delete-comment/{id}', [
        'as'=>'delete-comment',
        'uses'=>'Api\CommentServiceController@destroy'
    ]);
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
});
