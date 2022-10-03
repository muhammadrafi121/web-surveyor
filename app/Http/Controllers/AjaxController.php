<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\Location;
use App\Models\Row;
use App\Models\Tower;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function inventory(Request $request)
    {
        return Inventory::with(['locations', 'teams'])->where('id', $request->id)->get();
    }

    public function location(Request $request)
    {
        return Location::with(['towers', 'rows.firsttower', 'rows.secondtower'])->where('id', $request->id)->get();
    }

    public function allRow()
    {
        return Row::with(['firsttower', 'secondtower', 'location.inventory'])->get()->collect();
    }

    public function row(Request $request)
    {
        return Row::with(['firsttower', 'secondtower', 'location.inventory'])->where('id', $request->id)->get();
    }

    public function tower(Request $request)
    {
        return Tower::with(['location.inventory'])->where('id', $request->id)->get();
    }

    public function land(Request $request)
    {
        return json_decode(Land::with(['tower', 'row', 'plants', 'owner'])->find($request->id));
    }
}
