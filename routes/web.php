<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
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
        'title' => 'Peta',
        'script' => 'map'
    ]);
})->middleware('can:isAdmin');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/report', [DashboardController::class, 'report'])->middleware('auth');

// route user
Route::resource('user', UserController::class)->middleware('auth');

// route tower
Route::get('tower/{tower}/print', [TowerController::class, 'print'])->middleware('auth');
Route::put('tower/{tower}/upload', [TowerController::class, 'upload'])->middleware('auth');
Route::get('tower/{tower}/download', [TowerController::class, 'download'])->middleware('auth');
Route::get('tower/export', [TowerController::class, 'export'])->middleware('auth');
Route::resource('tower', TowerController::class)->middleware('auth');

// route ROW
Route::get('row/{row}/print', [RowController::class, 'print'])->middleware('auth');
Route::put('row/{row}/upload', [RowController::class, 'upload'])->middleware('auth');
Route::get('row/{row}/download', [RowController::class, 'download'])->middleware('auth');
Route::get('row/export', [RowController::class, 'export'])->middleware('auth');
Route::resource('row', RowController::class)->middleware('auth');

// route land
Route::get('land/{land}/print', [LandController::class, 'print'])->middleware('auth');
Route::put('land/{land}/upload', [LandController::class, 'upload'])->middleware('auth');
Route::get('land/{land}/download', [LandController::class, 'download'])->middleware('auth');
Route::get('land/export', [LandController::class, 'export'])->middleware('auth');
Route::resource('land', LandController::class)->middleware('auth');

// route plant
Route::resource('plant', PlantController::class)->middleware('auth');

// route daily report
Route::resource('dailyreport', DailyReportController::class)->middleware('auth');

// route inventory
Route::resource('inventory', InventoryController::class)->middleware('auth');

// route locations
Route::resource('location', LocationController::class)->middleware('auth');

// route help page
Route::get('feedback/admin', [FeedbackController::class, 'showAdminMsg'])->middleware('auth');
Route::get('feedback/forum', [FeedbackController::class, 'showForum'])->middleware('auth');
Route::resource('feedback', FeedbackController::class)->middleware('auth');

// route ajax
Route::get('/ajax/inventory', [AjaxController::class, 'inventory'])->middleware('auth');
Route::get('/ajax/location', [AjaxController::class, 'location'])->middleware('auth');
Route::get('/ajax/tower', [AjaxController::class, 'tower'])->middleware('auth');
Route::get('/ajax/allrow', [AjaxController::class, 'allRow'])->middleware('auth');
Route::get('/ajax/row', [AjaxController::class, 'row'])->middleware('auth');
Route::get('/ajax/land', [AjaxController::class, 'land'])->middleware('auth');
Route::get('/ajax/dailyreport', [AjaxController::class, 'dailyreport'])->middleware('auth');
Route::get('/ajax/rowinv', [AjaxController::class, 'rowsByInv'])->middleware('auth');
Route::get('/ajax/towerinv', [AjaxController::class, 'towersByInv'])->middleware('auth');
Route::get('/ajax/rowloc', [AjaxController::class, 'rowsByLoc'])->middleware('auth');
Route::get('/ajax/towerloc', [AjaxController::class, 'towersByLoc'])->middleware('auth');
Route::get('/ajax/rowteam', [AjaxController::class, 'rowsByTeam'])->middleware('auth');
Route::get('/ajax/towerteam', [AjaxController::class, 'towersByTeam'])->middleware('auth');
