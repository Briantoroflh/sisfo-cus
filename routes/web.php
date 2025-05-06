<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\DetailReturnController;
use App\Http\Controllers\DetailBorrowController;
use App\Http\Controllers\CategoryItemsController;
use App\Http\Controllers\BorrowedController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('Login.Login');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard.Home');

    Route::get('/dashboard/users', function () {
        return view('UserPage.Home');
    });

    Route::get('/dashboard/users/create', function () {
        return view('UserPage.Create');
    });

    Route::get('/dashboard/users/edit/{id}', function () {
        return view('UserPage.Edit');
    })->where('id', '[0-9]+');

    Route::get('/dashboard/category-items', function () {
        return view('KategoriPage.Home');
    });

    Route::get('/dashboard/items', function () {
        return view('ItemsPage.Home');
    });

    Route::get('/dashboard/items/create', function () {
        return view('ItemsPage.Create');
    });

    Route::get('/dashboard/items/edit/{id}', function () {
        return view('ItemsPage.Edit');
    })->where('id', '[0-9]+');

    Route::get('/dashboard/peminjaman', function () {
        return view('PeminjamanPage.Home');
    });

    Route::get('/dashboard/pengembalian', function () {
        return view('PengembalianPage.Home');
    });    
});




