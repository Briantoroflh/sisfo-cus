<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemsController;
use App\Http\Controllers\DetailReturnController;
use App\Http\Controllers\DetailBorrowController;
use App\Http\Controllers\CategoryItemsController;
use App\Http\Controllers\BorrowedController;

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

// Items
Route::get('items', [ItemsController::class, 'index']);
Route::post('items', [ItemsController::class, 'store']);
Route::get('items/{id}', [ItemsController::class, 'show']);
Route::put('items/{id}', [ItemsController::class, 'update']);
Route::delete('items/{id}', [ItemsController::class, 'destroy']);

// Detail Returns
Route::get('detail-returns', [DetailReturnController::class, 'index']);
Route::post('detail-returns', [DetailReturnController::class, 'store']);
Route::get('detail-returns/{id}', [DetailReturnController::class, 'show']);
Route::put('detail-returns/{id}', [DetailReturnController::class, 'update']);
Route::delete('detail-returns/{id}', [DetailReturnController::class, 'destroy']);

// Details Borrow
Route::get('details-borrow', [DetailBorrowController::class, 'index']);
Route::post('details-borrow', [DetailBorrowController::class, 'store']);
Route::get('details-borrow/{id}', [DetailBorrowController::class, 'show']);
Route::put('details-borrow/{id}', [DetailBorrowController::class, 'update']);
Route::delete('details-borrow/{id}', [DetailBorrowController::class, 'destroy']);

// Category Items
Route::get('category-items', [CategoryItemsController::class, 'index']);
Route::post('category-items', [CategoryItemsController::class, 'store']);
Route::get('category-items/{id}', [CategoryItemsController::class, 'show']);
Route::put('category-items/{id}', [CategoryItemsController::class, 'update']);
Route::delete('category-items/{id}', [CategoryItemsController::class, 'destroy']);

// Borrowed
Route::get('borrowed', [BorrowedController::class, 'index']);
Route::post('borrowed', [BorrowedController::class, 'store']);
Route::get('borrowed/{id}', [BorrowedController::class, 'show']);
Route::put('borrowed/{id}', [BorrowedController::class, 'update']);
Route::delete('borrowed/{id}', [BorrowedController::class, 'destroy']);