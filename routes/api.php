<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/inventories', [APIController::class, 'inventories']);
Route::get('/inventory/{inventory}', [APIController::class, 'inventory']);

Route::get('/locations', [APIController::class, 'locations']);
Route::get('/locations/{inventory}', [APIController::class, 'locationByInventory']);
Route::get('/location/{location}', [APIController::class, 'location']);

Route::get('/rows', [APIController::class, 'rows']);
Route::get('/rows/total/inventories', [APIController::class, 'rowsByInv']);
Route::get('/rows/total/locations', [APIController::class, 'rowsByLoc']);
Route::get('/rows/total/teams', [APIController::class, 'rowsByTeam']);
Route::get('/rows/{location}', [APIController::class, 'rowByLocation']);
Route::get('/row/{row}', [APIController::class, 'row']);

Route::get('/towers', [APIController::class, 'towers']);
Route::get('/towers/total/inventories', [APIController::class, 'towersByInv']);
Route::get('/towers/total/locations', [APIController::class, 'towersByLoc']);
Route::get('/towers/total/teams', [APIController::class, 'towersByTeam']);
Route::get('/towers/{location}', [APIController::class, 'towerbyLocation']);
Route::get('/tower/{tower}', [APIController::class, 'tower']);

Route::get('/lands', [APIController::class, 'lands']);
Route::get('/lands/tower/{tower}', [APIController::class, 'landByTower']);
Route::get('/lands/row/{row}', [APIController::class, 'landByRow']);
Route::get('/land/{land}', [APIController::class, 'land']);

Route::get('/dailyreports', [APIController::class, 'dailyreports']);
Route::get('/dailyreports/team/{team}', [APIController::class, 'dailyreportByTeam']);
Route::get('/dailyreports/location/{location}', [APIController::class, 'dailyreportByLocation']);
Route::get('/dailyreport/{dailyreport}', [APIController::class, 'dailyreport']);

Route::get('/summary', [APIController::class, 'summary']);