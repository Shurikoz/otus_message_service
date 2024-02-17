<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('register', [RegisterController::class, 'register']);

Route::get('user/search', [UserController::class, 'search']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('user', UserController::class)->only(['show']);
    Route::get('posts/feed', [PostController::class, 'index']);
    Route::post('posts/create', [PostController::class, 'store']);
});

