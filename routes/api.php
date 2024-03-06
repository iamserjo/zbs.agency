<?php

use App\Http\Controllers\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('users', [UserController::class, 'register']);
    Route::get('users', [UserController::class, 'getUsers']);
    Route::get('users/{user}', [UserController::class, 'getUserById']);
    Route::get('token', [UserController::class, 'generateToken']);
    Route::get('positions', [PositionController::class, 'index']);


});
