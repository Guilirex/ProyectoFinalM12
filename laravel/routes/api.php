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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Rutas para ReviewController
Route::apiResource('reviews', 'App\Http\Controllers\Api\ReviewController');

// Rutas para RouteController
Route::apiResource('routes', 'App\Http\Controllers\Api\RouteController');

// Rutas para MessageController
Route::apiResource('messages', 'App\Http\Controllers\Api\MessageController');

// Rutas para RegisterController
Route::apiResource('register', 'App\Http\Controllers\Api\RegisterController');
