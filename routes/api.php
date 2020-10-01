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
Route::post('post', [
    'as'=>'post',
    'uses'=>'Api\PostController@index'
]);
// Get a Post
Route::get('post/{id}', [
    'as'=>'post',
    'uses'=>'Api\PostController@show'
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
    //Get my post
    Route::post('my-post', [
        'as'=>'my-post',
        'uses'=>'Api\PostController@mypost'
    ]);
    //Update post
    Route::post('update-post/{id}', [
        'as'=>'update-post',
        'uses'=>'Api\PostController@update'
    ]);
    // Delete post
    Route::post('delete-post/{id}', [
        'as'=>'delete-post',
        'uses'=>'Api\PostController@destroy'
    ]);

    // Search
    Route::get('search/result', [
        'as'=>'search/result',
        'uses'=>'Api\SearchServiceController@index'
    ]);
});
