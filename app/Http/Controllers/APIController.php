<?php

namespace App\Http\Controllers;

use App\Http\Resources\APIResource;
use App\Models\DailyReport;
use App\Models\Inventory;
use App\Models\Land;
use App\Models\Location;
use App\Models\Row;
use App\Models\Team;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Api;

class APIController extends Controller
{
    // get all inventories
    public function inventories()
    {
        $inventories = Inventory::all();
        return new APIResource(true, 'List Inventaris', $inventories);
    }
    
    // get inventory by id
    public function inventory(Inventory $inventory)
    {
        $inventory = Inventory::where('id', $inventory->id)->get();
        return new APIResource(true, 'Data Inventaris', $inventory);
    }
    
    // get all locations
    public function locations()
    {
        $locations = Location::all();
        return new APIResource(true, 'List Data Jalur', $locations);
    }
    
    // get location by id
    public function location(Location $location)
    {
        $location = Location::where('id', $location->id)->get();
        return new APIResource(true, 'Data Jalur', $location);
    }

    // get location by inventory
    public function locationByInventory(Inventory $inventory) {
        $locations = Location::where('inventory_id', $inventory->id)->get();
        return new APIResource(true, 'Data Jalur Berdasarkan Inventaris', $locations);
    }

    // get all rows
    public function rows()
    {
        $rows = Row::all();
        return new APIResource(true, 'List RoW', $rows);
    }

    // get row by id
    public function row(Row $row)
    {
        $row = Row::where('id', $row->id)->get();
        return new APIResource(true, 'Data RoW', $row);
    }

    // get row by location
    public function rowByLocation(Location $location) {
        $rows = Row::where('location_id', $location->id)->get();
        return new APIResource(true, 'Data RoW Berdasarkan Jalur', $rows);
    }

    // get all tower
    public function towers()
    {
        $towers = Tower::all();
        return new APIResource(true, 'List Tower', $towers);
    }
    
    // get tower by id
    public function tower(Tower $tower)
    {
        $tower = Tower::where('id', $tower->id)->get();
        return new APIResource(true, 'Data Tapak Tower', $tower);
    }

    //get tower by location
    public function towerByLocation(Location $location)
    {
        $towers = Tower::where('location_id', $location->id)->get();
        return new APIResource(true, 'Data Tapak Tower Berdasarkan Jalur', $towers);
    }

    // get all lands
    public function lands()
    {
        $lands = Land::with(['plants', 'owner'])->get();
        return new APIResource(true, 'List Lahan', $lands);
    }

    // get lands by tower
    public function landByTower(Tower $tower)
    {
        $lands = Land::with(['tower', 'plants', 'owner'])->where('tower_id', $tower->id)->get();
        return new APIResource(true, 'Data Lahan di Tapak Tower', $lands);
    }

    // get lands by row
    public function landByRow(Row $row)
    {
        $lands = Land::with(['row', 'plants', 'owner'])->where('row_id', $row->id)->get();
        return new APIResource(true, 'Data Lahan di RoW', $lands);
    }

    // get lands by id
    public function land(Land $land)
    {
        $land = Land::with(['row', 'plants', 'owner'])->where('id', $land->id)->get();
        return new APIResource(true, 'Data Lahan', $land);
    }

    // get all daily reports
    public function dailyreports()
    {
        $reports = DailyReport::with(['facilities', 'manPowers', 'images'])->get();
        return new APIResource(true, 'List Daily Report', $reports);
    }

    // get daily reports by team
    public function dailyreportByTeam(Team $team)
    {
        $reports = DailyReport::with(['facilities', 'manPowers', 'images'])->where('team_id', $team->id)->get();
        return new APIResource(true, 'Data Daily Report Berdasarkan Tim', $reports);
    }

    // get daily reports by location
    public function dailyreportByLocation(Location $location)
    {
        $reports = DailyReport::with(['facilities', 'manPowers', 'images'])->where('location_id', $location->id)->get();
        return new APIResource(true, 'Data Daily Report Berdasarkan Jalur', $reports);
    }

    // get daily report by id
    public function dailyreport(DailyReport $dailyreport)
    {
        $report = DailyReport::with(['facilities', 'manPowers', 'images'])->where('id', $dailyreport->id)->get();
        return new APIResource(true, 'Data Daily Report', $report);
    }

    // get towers total by inventories
    public function towersByInv()
    {
        $filled = DB::table('towers')
            ->select('inventories.name', DB::raw('IFNULL(COUNT(DISTINCT(towers.id)), 0) as filled'))
            ->join('lands', 'towers.id', '=', 'lands.tower_id')
            ->join('locations', 'towers.location_id', '=', 'locations.id')
            ->rightJoin('inventories', 'locations.inventory_id', '=', 'inventories.id')
            ->groupBy('inventories.name')
            ->orderBy('inventories.name')
            ->get();
        $total = DB::table('towers')
            ->select('inventories.name', DB::raw('COUNT(towers.id) as total'))
            ->join('locations', 'towers.location_id', '=', 'locations.id')
            ->rightJoin('inventories', 'locations.inventory_id', '=', 'inventories.id')
            ->groupBy('inventories.name')
            ->orderBy('inventories.name')
            ->get();

        $data = [];
        for ($i = 0; $i < sizeof($filled); $i++) {
            array_push($data, [
                'name' => $filled[$i]->name,
                'filled' => $filled[$i]->filled,
                'total' => $total[$i]->total,
            ]);
        }
        return new APIResource(true, 'Total Tapak Tower Berdasarkan Inventaris', $data);
    }

    // get rows total by inventories
    public function rowsByInv()
    {
        $filled = DB::table('rows')
            ->select('inventories.name', DB::raw('IFNULL(COUNT(DISTINCT(rows.id)), 0) as filled'))
            ->join('lands', 'rows.id', '=', 'lands.row_id')
            ->join('locations', 'rows.location_id', '=', 'locations.id')
            ->rightJoin('inventories', 'locations.inventory_id', '=', 'inventories.id')
            ->groupBy('inventories.name')
            ->orderBy('inventories.name')
            ->get();
        $total = DB::table('rows')
            ->select('inventories.name', DB::raw('COUNT(rows.id) as total'))
            ->join('locations', 'rows.location_id', '=', 'locations.id')
            ->rightJoin('inventories', 'locations.inventory_id', '=', 'inventories.id')
            ->groupBy('inventories.name')
            ->orderBy('inventories.name')
            ->get();

        $data = [];
        for ($i = 0; $i < sizeof($filled); $i++) {
            array_push($data, [
                'name' => $filled[$i]->name,
                'filled' => $filled[$i]->filled,
                'total' => $total[$i]->total,
            ]);
        }

        return new APIResource(true, 'Total RoW Berdasrakan Inventaris', $data);
    }

    // get tower's total by locations
    public function towersByLoc()
    {
        $filled = DB::table('towers')
            ->select('locations.name', DB::raw('IFNULL(COUNT(DISTINCT(towers.id)), 0) as filled'))
            ->join('lands', 'towers.id', '=', 'lands.tower_id')
            ->rightJoin('locations', 'towers.location_id', '=', 'locations.id')
            ->groupBy('locations.name')
            ->orderBy('locations.name')
            ->get();
        $total = DB::table('towers')
            ->select('locations.name', DB::raw('COUNT(towers.id) as total'))
            ->rightJoin('locations', 'towers.location_id', '=', 'locations.id')
            ->groupBy('locations.name')
            ->orderBy('locations.name')
            ->get();

        $data = [];
        for ($i = 0; $i < sizeof($filled); $i++) {
            array_push($data, [
                'name' => $filled[$i]->name,
                'filled' => $filled[$i]->filled,
                'total' => $total[$i]->total,
            ]);
        }

        return new APIResource(true, 'Total Tapak Tower Berdasarkan Jalur', $data);
    }

    // get row's total by locations
    public function rowsByLoc()
    {
        $filled = DB::table('rows')
            ->select('locations.name', DB::raw('IFNULL(COUNT(DISTINCT(rows.id)), 0) as filled'))
            ->join('lands', 'rows.id', '=', 'lands.row_id')
            ->rightJoin('locations', 'rows.location_id', '=', 'locations.id')
            ->groupBy('locations.name')
            ->orderBy('locations.name')
            ->get();
        $total = DB::table('rows')
            ->select('locations.name', DB::raw('COUNT(rows.id) as total'))
            ->rightJoin('locations', 'rows.location_id', '=', 'locations.id')
            ->groupBy('locations.name')
            ->orderBy('locations.name')
            ->get();

        $data = [];
        for ($i = 0; $i < sizeof($filled); $i++) {
            array_push($data, [
                'name' => $filled[$i]->name,
                'filled' => $filled[$i]->filled,
                'total' => $total[$i]->total,
            ]);
        }

        return new APIResource(true, 'Total RoW Berdasarkan Jalur', $data);
    }

    // get tower's total by teams
    public function towersByTeam()
    {
        $filled = DB::table('towers')
            ->select('users.name', DB::raw('IFNULL(COUNT(DISTINCT(towers.id)), 0) as filled'))
            ->join('lands', 'towers.id', '=', 'lands.tower_id')
            ->join('locations', 'towers.location_id', '=', 'locations.id')
            ->rightJoin('users', 'towers.user_id', '=', 'users.id')
            ->where('users.role', 'Administrator')
            ->orWhere('users.role', 'Surveyor')
            ->groupBy('users.name')
            ->orderBy('users.id')
            ->get();
        $total = DB::table('towers')
            ->select('users.name', DB::raw('COUNT(towers.id) as total'))
            ->join('locations', 'towers.location_id', '=', 'locations.id')
            ->rightJoin('users', 'towers.user_id', '=', 'users.id')
            ->where('users.role', 'Administrator')
            ->orWhere('users.role', 'Surveyor')
            ->groupBy('users.name')
            ->orderBy('users.id')
            ->get();

        $data = [];
        for ($i = 0; $i < sizeof($filled); $i++) {
            array_push($data, [
                'name' => $filled[$i]->name,
                'filled' => $filled[$i]->filled,
                'total' => $total[$i]->total,
            ]);
        }

        return new APIResource(true, 'Total Tapak Tower Berdasarkan Tim', $data);
    }

    // get row's total by teams
    public function rowsByTeam()
    {
        $filled = DB::table('rows')
            ->select('users.name', DB::raw('IFNULL(COUNT(DISTINCT(rows.id)), 0) as filled'))
            ->join('lands', 'rows.id', '=', 'lands.row_id')
            ->join('locations', 'rows.location_id', '=', 'locations.id')
            ->rightJoin('users', 'rows.user_id', '=', 'users.id')
            ->where('users.role', 'Administrator')
            ->orWhere('users.role', 'Surveyor')
            ->groupBy('users.name')
            ->orderBy('users.id')
            ->get();
        $total = DB::table('rows')
            ->select('users.name', DB::raw('COUNT(rows.id) as total'))
            ->join('locations', 'rows.location_id', '=', 'locations.id')
            ->rightJoin('users', 'rows.user_id', '=', 'users.id')
            ->where('users.role', 'Administrator')
            ->orWhere('users.role', 'Surveyor')
            ->groupBy('users.name')
            ->orderBy('users.id')
            ->get();

        $data = [];
        for ($i = 0; $i < sizeof($filled); $i++) {
            array_push($data, [
                'name' => $filled[$i]->name,
                'filled' => $filled[$i]->filled,
                'total' => $total[$i]->total,
            ]);
        }

        return new APIResource(true, 'Total RoW Berdasarkan Tim', $data);
    }

    // get row and tower's summary
    public function summary(Request $request)
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

        $row_perc = is_int(($filled_row * 100) / $row) ? ($filled_row * 100) / $row : number_format((float) (($filled_row * 100) / $row), 2, '.', '');
        $tower_perc = is_int(($filled_tower * 100) / $tower) ? ($filled_tower * 100) / $tower : number_format((float) (($filled_tower * 100) / $tower), 2, '.', '');

        return new APIResource(true, 'Persentase RoW dan Tapak Tower', ['row' => $row_perc, 'tower' => $tower_perc]);
    }
}
