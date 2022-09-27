<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\RowController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|s
*/

Route::get('/', [LoginController::class, 'index'])->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/map', function () {
    return view('map', [
        'title' => 'Peta'
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard',
        'script' => 'dashboard',
    ]);
})->middleware('auth');

// route user
Route::resource('user', UserController::class)->middleware('auth');

// route tower
Route::resource('tower', TowerController::class)->middleware('auth');

// route ROW
Route::resource('row', RowController::class)->middleware('auth');

// route land
Route::resource('land', LandController::class)->middleware('auth');

// route plant
Route::resource('plant', PlantController::class)->middleware('auth');

// route daily report
Route::resource('dailyreport', DailyReportController::class)->middleware('auth');

// route inventory
Route::resource('inventory', InventoryController::class)->middleware('auth');

// route locations
Route::resource('location', LocationController::class)->middleware('auth');

// route ajax
Route::get('/ajax/inventory', [AjaxController::class, 'inventory'])->middleware('auth');