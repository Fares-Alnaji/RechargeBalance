<?php

use App\Http\Controllers\Auth\Api\ApiAuthController;
use App\Http\Controllers\TransformationController;
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

Route::prefix('auth')->group(function () {
    Route::post('register',[ApiAuthController::class, 'register']);
    Route::post('login',[ApiAuthController::class, 'personalLogin']);
});

Route::middleware('auth:admin-api')->group(function () {
    Route::get('Transformation', [TransformationController::class , 'index']);
});

Route::prefix('auth')->middleware('auth:admin-api')->group(function () {
    Route::get('logout',[ApiAuthController::class, 'logout']);
});
