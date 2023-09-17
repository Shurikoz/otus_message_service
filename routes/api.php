<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [RegisterController::class, 'register']);
Route::apiResource('user', UserController::class)->only(['show']);

Route::middleware('auth:api')->group( function () {
//    Route::apiResource('user', UserController::class)->only(['show']);
});

//Route::get('user/{id}', 'API\RegisterController@register');
//Route::get("user/{id}", [UserController::class, 'formData']);
//Route::get("user/{id}", 'API\UserController@show');
