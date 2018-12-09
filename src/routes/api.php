<?php

use Illuminate\Http\Request;

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

//Users
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'UserController@details');
});
//Projects
Route::get('projects', 'ProjectsController@index');
Route::get('projects/{id}', 'ProjectsController@show');
Route::post('projects', 'ProjectsController@store');
Route::put('projects', 'ProjectsController@store'); 
Route::delete('projects/{id}', 'ProjectsController@destroy');