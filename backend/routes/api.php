<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([ 'middleware' => 'api' ], function() {
    // Route::post('auth/login', [ AuthController::class, 'login' ]);
    Route::post('auth/logout', [ AuthController::class, 'logout' ]);
    Route::post('auth/refresh', [ AuthController::class, 'refresh' ]);
    Route::post('auth/me', [ AuthController::class, 'me' ]);
});

