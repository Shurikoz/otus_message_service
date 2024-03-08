<?php

use App\Http\Controllers\API\MessengerController;
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
    Route::post('post/create', [PostController::class, 'store']);
    Route::post('/post/feed/posted', [PostController::class, 'posted']);

    Route::get('/messenger/channel', [MessengerController::class, 'channel']);
    Route::get('/messenger/postgres', [MessengerController::class, 'postMessageInPostgres']);
    Route::get('/messenger/tarantool', [MessengerController::class, 'postMessageInTarantool']);

    Route::get('/messenger', [MessengerController::class, 'messenger']);
});

