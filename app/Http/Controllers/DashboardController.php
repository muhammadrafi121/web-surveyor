<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Tower;
use App\Models\Row;

class DashboardController extends Controller
{
    public function index()
    {
        $filled_row = Row::join('lands', 'rows.id', '=', 'lands.row_id')
            ->distinct('rows.id')
            ->groupBy('rows.id')
            ->count();
        $row = Row::all()->count();
        $filled_tower = Tower::join('lands', 'towers.id', '=', 'lands.tower_id')
            ->distinct('towers.id')
            ->groupBy('towers.id')
            ->count();
        $tower = Tower::all()->count();

        if (auth()->user()->role == 'Client') {
            $filled_row = Row::join('lands', 'rows.id', '=', 'lands.row_id')
                ->join('locations', 'rows.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->distinct('rows.id')
                ->groupBy('inventories.id')
                ->count();
            $row = Row::join('locations', 'rows.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->count();
            $filled_tower = Tower::join('lands', 'towers.id', '=', 'lands.tower_id')
                ->join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->distinct('towers.id')
                ->groupBy('inventories.id')
                ->count();
            $tower = Tower::join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->count();
        }

        $row_perc = is_int(($filled_row * 100) / $row) ? ($filled_row * 100) / $row : number_format((float) (($filled_row * 100) / $row), 2, '.', '');
        $tower_perc = is_int(($filled_tower * 100) / $tower) ? ($filled_tower * 100) / $tower : number_format((float) (($filled_tower * 100) / $tower), 2, '.', '');

        return view('dashboard', [
            'title' => 'Dashboard',
            'row' => $row_perc,
            'tower' => $tower_perc,
            'script' => 'dashboard',
        ]);
    }

    public function report()
    {
        $inventories = Inventory::all();
        $filled_row = Row::join('lands', 'rows.id', '=', 'lands.row_id')
            ->distinct('rows.id')
            ->groupBy('rows.id')
            ->count();
        $row = Row::all()->count();
        $filled_tower = Tower::join('lands', 'towers.id', '=', 'lands.tower_id')
            ->distinct('towers.id')
            ->groupBy('towers.id')
            ->count();
        $tower = Tower::all()->count();

        if (auth()->user()->role == 'Client') {
            $inventories = Inventory::where('id', auth()->user()->inventory->id)->get();
            $filled_row = Row::join('lands', 'rows.id', '=', 'lands.row_id')
                ->join('locations', 'rows.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->distinct('rows.id')
                ->groupBy('inventories.id')
                ->count();
            $row = Row::join('locations', 'rows.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->count();
            $filled_tower = Tower::join('lands', 'towers.id', '=', 'lands.tower_id')
                ->join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->distinct('towers.id')
                ->groupBy('inventories.id')
                ->count();
            $tower = Tower::join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', auth()->user()->inventory->id)
                ->count();
        }

        $row_perc = is_int(($filled_row * 100) / $row) ? ($filled_row * 100) / $row : number_format((float) (($filled_row * 100) / $row), 2, '.', '');
        $tower_perc = is_int(($filled_tower * 100) / $tower) ? ($filled_tower * 100) / $tower : number_format((float) (($filled_tower * 100) / $tower), 2, '.', '');

        return view('report', [
            'title' => 'Laporan',
            'inventories' => $inventories,
            'row' => $row_perc,
            'tower' => $tower_perc,
            'script' => 'report',
        ]);
    }
}
