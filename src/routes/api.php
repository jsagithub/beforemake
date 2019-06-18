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
Route::post('projects', 'ProjectsController@store');
Route::put('projects', 'ProjectsController@store'); 
Route::delete('projects/{id}', 'ProjectsController@destroy');
//Stories
Route::get('stories', 'StoriesController@index');
Route::get('stories/{id}', 'StoriesController@show');
Route::get('stories_by_project/{id_project}', 'StoriesController@show_by_project');
Route::post('stories', 'StoriesController@store');
Route::put('stories', 'StoriesController@store'); 
Route::delete('stories/{id}', 'StoriesController@destroy');
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
Route::post('images', 'ImagesController@store');
Route::put('images', 'ImagesController@store'); 
Route::delete('images/{id}', 'ImagesController@destroy');
//Social Media
Route::get('social', 'SocialMediasController@index');
Route::get('social/{id}', 'SocialMediasController@show');
Route::get('social_by_project/{id_project}', 'SocialMediasController@show_by_project');
Route::post('social', 'SocialMediasController@store');
Route::put('social', 'SocialMediasController@store');
Route::delete('social/{id}', 'SocialMediasController@destroy');
//videos
Route::get('videos', 'VideosController@index');
Route::get('videos_by_storie/{id_storie}', 'VideosController@show_by_storie');
Route::post('videos', 'VideosController@store');
Route::put('videos', 'VideosController@store');
Route::delete('videos/{id}', 'VideosController@destroy');
//Rankings
Route::get('rankings', 'RankingsController@index');
Route::get('rankings_by_project/{id_project}', 'RankingsController@rankings_by_project');
Route::get('rankings_by_status/{id_status}', 'RankingsController@rankings_by_status');
Route::post('rankings', 'RankingsController@store');
Route::put('rankings', 'RankingsController@store');
Route::delete('ranking/{id}', 'RankingsController@destroy');