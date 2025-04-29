<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'Login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'Me']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');

    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
    });

});