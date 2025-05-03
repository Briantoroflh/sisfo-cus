<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

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

// Route::middleware(RoleMiddleware::class)->group(function () {
    
// });

Route::get('/dashboard', function () {
    return view('Dashboard.Home');
});

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

