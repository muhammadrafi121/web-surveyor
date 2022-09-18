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
    return view('welcome');
});

Route::get('/map', function () {
    return view('map');
});

// route user
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/edit', [UserController::class, 'edit']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user', [UserController::class, 'update']);
Route::delete('/user', [UserController::class, 'destroy']);

// route tower
Route::get('/tower', [TowerController::class, 'index']);
Route::get('/tower/edit', [TowerController::class, 'edit']);
Route::get('/tower/{tower}', [TowerController::class, 'show']);
Route::post('/tower', [TowerController::class, 'store']);
Route::put('/tower', [TowerController::class, 'update']);
Route::delete('/tower', [TowerController::class, 'destroy']);

// route ROW
Route::get('/row', [RowController::class, 'index']);
Route::get('/row/edit', [RowController::class, 'edit']);
Route::get('/row/{row}', [RowController::class, 'show']);
Route::post('/row', [RowController::class, 'store']);
Route::put('/row', [RowController::class, 'update']);
Route::delete('/row', [RowController::class, 'destroy']);

// route land
Route::get('/land', [LandController::class, 'index']);
Route::get('/land/edit', [LandController::class, 'edit']);
Route::get('/land/{land}', [LandController::class, 'show']);
Route::post('/land', [LandController::class, 'store']);
Route::put('/land', [LandController::class, 'update']);
Route::delete('/land', [LandController::class, 'delete']);