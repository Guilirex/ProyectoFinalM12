<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/channels.php';

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
// */
// use Fruitcake\Cors\HandleCors;

// Route::middleware([HandleCors::class])->group(function () {
//     Route::get('/routes', 'RouteController@index');
    


// });




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Rutas para ReviewController
Route::apiResource('reviews', 'App\Http\Controllers\Api\ReviewController');

// Rutas para RouteController
Route::apiResource('routes', 'App\Http\Controllers\Api\RouteController');

// Rutas para FileController
Route::apiResource('files', 'App\Http\Controllers\Api\FileController');

// Rutas para TokenController
Route::apiResource('user', 'App\Http\Controllers\Api\TokenController');

// Rutas para MessageController
Route::apiResource('messages', 'App\Http\Controllers\Api\MessageController')
->middleware('auth:sanctum');


// Rutas para FollowerController
Route::apiResource('followers', 'App\Http\Controllers\Api\FollowerController')
->middleware('auth:sanctum');

// Rutas para UsersController
// Route::apiResource('users', 'App\Http\Controllers\Api\UserController');

// // Rutas para RegisterController
// Route::post('register', 'App\Http\Controllers\Api\RegisterController@register');


Route::post('register', 'App\Http\Controllers\Api\TokenController@register');
Route::post('login', 'App\Http\Controllers\Api\TokenController@login');
Route::post('logout', 'App\Http\Controllers\Api\TokenController@logout')
->middleware('auth:sanctum');

Route::get('user', 'App\Http\Controllers\Api\TokenController@user')
->middleware('auth:sanctum');

Route::get('users', 'App\Http\Controllers\Api\TokenController@index');
Route::get('user/{id}', 'App\Http\Controllers\Api\TokenController@show');
 
Route::post('user/{user}', 'App\Http\Controllers\Api\TokenController@update')->middleware('auth:sanctum');


Route::get('users/{userId}/avatar', 'App\Http\Controllers\Api\TokenController@getUserAvatar');

Route::get('users/{userId}/posts', 'App\Http\Controllers\Api\TokenController@getUserPosts');

Route::post('users/postuserfiles', 'App\Http\Controllers\Api\TokenController@postUserFiles');


Route::post('/routes/{route}/inscription', 'App\Http\Controllers\Api\RouteController@inscription')
->middleware('auth:sanctum');
Route::delete('/routes/{route}/uninscription', 'App\Http\Controllers\Api\RouteController@uninscription')
->middleware('auth:sanctum');
Route::get('/inscriptions', 'App\Http\Controllers\Api\RouteController@inscriptions');
Route::get('/routes', 'App\Http\Controllers\Api\RouteController@index');



Route::post('/subscribe', 'App\Http\Controllers\Api\SubscriptionController@subscribe')
->middleware('auth:sanctum');
