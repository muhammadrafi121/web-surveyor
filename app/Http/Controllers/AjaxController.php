<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\Inventory;
use App\Models\Land;
use App\Models\Location;
use App\Models\Row;
use App\Models\Team;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function inventory(Request $request)
    {
        return Inventory::with(['locations', 'teams'])
            ->where('id', $request->id)
            ->get();
    }

    public function location(Request $request)
    {
        return Location::with(['towers', 'rows.firsttower', 'rows.secondtower'])
            ->where('id', $request->id)
            ->get();
    }

    public function allRow()
    {
        return Row::with(['firsttower', 'secondtower', 'location.inventory'])
            ->get()
            ->collect();
    }

    public function row(Request $request)
    {
        return Row::with(['firsttower', 'secondtower', 'location.inventory'])
            ->where('id', $request->id)
            ->get();
    }

    public function tower(Request $request)
    {
        return Tower::with(['location.inventory'])
            ->where('id', $request->id)
            ->get();
    }

    public function land(Request $request)
    {
        return json_decode(Land::with(['tower', 'row', 'plants', 'owner'])->find($request->id));
    }

    public function dailyreport(Request $request)
    {
        return json_decode(DailyReport::with(['location.inventory', 'facilities', 'manpowers', 'activities', 'team'])->find($request->id));
    }

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

        return $data;
    }

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

        return $data;
    }

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

        return $data;
    }

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

        return $data;
    }

    public function towersByTeam()
    {
        $filled = DB::table('towers')
            ->select('users.name', DB::raw('IFNULL(COUNT(DISTINCT(towers.id)), 0) as filled'))
            ->join('lands', 'towers.id', '=', 'lands.tower_id')
            ->join('locations', 'towers.location_id', '=', 'locations.id')
            ->rightJoin('users', 'towers.user_id', '=', 'users.id')
            ->groupBy('users.name')
            ->orderBy('users.id')
            ->get();
        $total = DB::table('towers')
            ->select('users.name', DB::raw('COUNT(towers.id) as total'))
            ->join('locations', 'towers.location_id', '=', 'locations.id')
            ->rightJoin('users', 'towers.user_id', '=', 'users.id')
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

        return $data;
    }

    public function rowsByTeam()
    {
        $filled = DB::table('rows')
            ->select('users.name', DB::raw('IFNULL(COUNT(DISTINCT(rows.id)), 0) as filled'))
            ->join('lands', 'rows.id', '=', 'lands.row_id')
            ->join('locations', 'rows.location_id', '=', 'locations.id')
            ->rightJoin('users', 'rows.user_id', '=', 'users.id')
            ->groupBy('users.name')
            ->orderBy('users.id')
            ->get();
        $total = DB::table('rows')
            ->select('users.name', DB::raw('COUNT(rows.id) as total'))
            ->join('locations', 'rows.location_id', '=', 'locations.id')
            ->rightJoin('users', 'rows.user_id', '=', 'users.id')
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

        return $data;
    }

    public function team()
    {
        return Team::with(['users', 'inventory'])->get();
    }
}
