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
//Stories
Route::get('stories', 'StoriesController@index');
Route::get('stories/{id}', 'StoriesController@show');
Route::post('stories', 'StoriesController@store');
Route::put('stories', 'StoriesController@store'); 
Route::delete('stories/{id}', 'StoriesController@destroy');
//Comments
Route::get('comments', 'CommentsController@index');
Route::get('comment/{id}', 'CommentsController@show');
Route::post('comment', 'CommentsController@store');
Route::put('comment', 'CommentsController@store'); 
Route::delete('comment/{id}', 'CommentsController@destroy');
//Images
Route::get('images', 'ImagesController@index');
Route::get('images/{id}', 'ImagesController@show');
Route::post('images', 'ImagesController@store');
Route::put('images', 'ImagesController@store'); 
Route::delete('images/{id}', 'ImagesController@destroy');