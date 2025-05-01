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

    // untuk profile
    Route::get('/me', [AuthController::class, 'Me']);

    // untuk melihat semua user dan detail user
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');

    // untuk melihat semua items dan detail items
    Route::get('items', [ItemsController::class, 'index']);
    Route::get('items/{id}', [ItemsController::class, 'show'])->where('id', '[0-9]+');

    // untuk melihat semua detail return dan detail return
    Route::get('/returns', [DetailReturnController::class, 'index']);
    Route::get('/returns/{id}', [DetailReturnController::class, 'show'])->where('id', '[0-9]+');

    // untuk melihat semua detail borrow dan detail borrow
    Route::get('/details-borrow', [DetailBorrowController::class, 'index']);
    Route::get('/details-borrow/{id}', [DetailBorrowController::class, 'show'])->where('id', '[0-9]+');

    // untuk melihat semua category items dan detail category items
    Route::get('category-items', [CategoryItemsController::class, 'index']);
    Route::get('category-items/{id}', [CategoryItemsController::class, 'show'])->where('id', '[0-9]+');

    // untuk melihat semua borrowed, detail borrowed dan membuat borrowed 
    Route::get('/borrowed', [BorrowedController::class, 'index']);
    Route::get('/borrowed/{id}', [BorrowedController::class, 'show']);
    Route::post('/borrowed', [BorrowedController::class, 'store']);

    Route::middleware(RoleMiddleware::class)->group(function () {

        //Users
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');

        // Items
        Route::post('items', [ItemsController::class, 'store']);
        Route::put('items/{id}', [ItemsController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('items/{id}', [ItemsController::class, 'destroy'])->where('id', '[0-9]+');

        // Detail Returns
        Route::post('detail-returns', [DetailReturnController::class, 'store']);
        Route::put('detail-returns/{id}', [DetailReturnController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('detail-returns/{id}', [DetailReturnController::class, 'destroy'])->where('id', '[0-9]+');

        // Details Borrow
        Route::post('details-borrow', [DetailBorrowController::class, 'store']);
        Route::put('details-borrow/{id}', [DetailBorrowController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('details-borrow/{id}', [DetailBorrowController::class, 'destroy'])->where('id', '[0-9]+');

        // Category Items
        Route::post('category-items', [CategoryItemsController::class, 'store']);
        Route::put('category-items/{id}', [CategoryItemsController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('category-items/{id}', [CategoryItemsController::class, 'destroy'])->where('id', '[0-9]+');

        // Borrowed
        Route::put('/borrowed/{id}/approve', [BorrowedController::class, 'approve']); // Approve
        Route::put('/borrowed/{id}/reject', [BorrowedController::class, 'reject']);
    });

});

