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

Route::middleware(['assign.guard:api','jwt.auth'])->group(function(){
   Route::get('get-info-account',[
    'as'=>'get-info-account',
    'uses'=> 'Api\LoginController@laythongtin'
]);
});
