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

Route::prefix('v1')->as('v1:')->group(
    base_path('routes/v1/api.php'),
);

Route::prefix('v2')->as('v2:')->group(
    base_path('routes/v2/api.php'),
);
