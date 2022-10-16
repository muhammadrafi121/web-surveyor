<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tower;
use App\Models\Row;

class DashboardController extends Controller
{
    public function index()
    {
        $filled_row = Row::join('lands', 'rows.id', '=', 'lands.row_id')->distinct('rows.id')->groupBy('rows.id')->count();
        $row = Row::all()->count();
        $filled_tower = Tower::join('lands', 'towers.id', '=', 'lands.tower_id')->count();
        $tower = Tower::all()->count();

        $row_perc = is_int($filled_row * 100 / $row) ? $filled_row * 100 / $row : number_format((float)($filled_row * 100 / $row), 2, '.', '');
        $tower_perc = is_int($filled_tower * 100 / $tower) ? $filled_tower * 100 / $tower : number_format((float)($filled_tower * 100 / $tower), 2, '.', '');

        return view('dashboard', [
            'title' => 'Dashboard',
            'row' => $row_perc,
            'tower' => $tower_perc,
            'script' => 'dashboard',
        ]);
    }
}
