<?php

use App\Http\Controllers\LandController;
use App\Http\Controllers\RowController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/map', function () {
    return view('map');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/tower', function () {
    return view('towerbaru');
});
Route::get('/tower/edit', function () {
    return view('inputtower');
});
Route::get('/row', function () {
    return view('rowbaru');
});
Route::get('/row/edit', function () {
    return view('inputrow');
});

// // route user
// Route::resource('user', UserController::class);

// // route tower
// Route::resource('tower', TowerController::class);

// // route ROW
// Route::resource('row', RowController::class);

// // route land
// Route::resource('land', LandController::class);