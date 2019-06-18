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
//Status
Route::get('project_status', 'ProjectStatusController@index');
//Projects
Route::get('projects', 'ProjectsController@index');
Route::get('projects/{id}', 'ProjectsController@show');
Route::get('projects_by_user/{id_user}', 'ProjectsController@show_by_user');
Route::get('projects_by_status/{id_status}', 'ProjectsController@show_by_status');
Route::post('projects', 'ProjectsController@store')->middleware('auth:api');
Route::put('projects', 'ProjectsController@store')->middleware('auth:api'); 
Route::delete('projects/{id}', 'ProjectsController@destroy')->middleware('auth:api');
//Stories
Route::get('stories', 'StoriesController@index');
Route::get('stories/{id}', 'StoriesController@show');
Route::get('stories_by_project/{id_project}', 'StoriesController@show_by_project');
Route::post('stories', 'StoriesController@store')->middleware('auth:api');
Route::put('stories', 'StoriesController@store')->middleware('auth:api'); 
Route::delete('stories/{id}', 'StoriesController@destroy')->middleware('auth:api');
//Comments
Route::get('comments', 'CommentsController@index');
Route::get('comment/{id}', 'CommentsController@show');
Route::get('comment_by_storie/{id_storie}', 'CommentsController@show_by_storie');
Route::post('comment', 'CommentsController@store')->middleware('auth:api');
Route::put('comment', 'CommentsController@store')->middleware('auth:api');
Route::delete('comment/{id}', 'CommentsController@destroy')->middleware('auth:api');
//Images
Route::get('images', 'ImagesController@index');
Route::get('images/{id}', 'ImagesController@show');
Route::get('images_by_storie/{id_storie}', 'ImagesController@show_by_storie');
Route::post('images', 'ImagesController@store')->middleware('auth:api');
Route::put('images', 'ImagesController@store')->middleware('auth:api'); 
Route::delete('images/{id}', 'ImagesController@destroy')->middleware('auth:api');
//Social Media
Route::get('social', 'SocialMediasController@index');
Route::get('social/{id}', 'SocialMediasController@show');
Route::get('social_by_project/{id_project}', 'SocialMediasController@show_by_project');
Route::post('social', 'SocialMediasController@store')->middleware('auth:api');
Route::put('social', 'SocialMediasController@store')->middleware('auth:api');
Route::delete('social/{id}', 'SocialMediasController@destroy')->middleware('auth:api');
//videos
Route::get('videos', 'VideosController@index');
Route::get('videos_by_storie/{id_storie}', 'VideosController@show_by_storie');
Route::post('videos', 'VideosController@store')->middleware('auth:api');
Route::put('videos', 'VideosController@store')->middleware('auth:api');
Route::delete('videos/{id}', 'VideosController@destroy')->middleware('auth:api');
//Rankings
Route::get('rankings', 'RankingsController@index');
Route::get('rankings_by_project/{id_project}', 'RankingsController@rankings_by_project');
Route::get('rankings_by_status/{id_status}', 'RankingsController@rankings_by_status');
Route::post('rankings', 'RankingsController@store');
Route::put('rankings', 'RankingsController@store');
Route::delete('ranking/{id}', 'RankingsController@destroy')->middleware('auth:api');