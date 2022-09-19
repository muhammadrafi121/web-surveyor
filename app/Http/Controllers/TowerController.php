<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Tower;
use Illuminate\Http\Request;

class TowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $towers = Tower::all();
        return [
            'towers' => $towers,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventories = Inventory::all();
        $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        return view('towerbaru', [
            'inventories' => $inventories,
            'locations' => $locations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jalur' => 'required',
            'tapak' => 'required',
        ]);

        $tower = new Tower();
        $tower->location_id = $request->jalur;
        $tower->no = $request->tapak;
        $tower->save();
        return redirect('/tower/' . $tower->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function show(Tower $tower)
    {
        return $tower;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function edit(Tower $tower, Request $request)
    {
        $land = Land::find($request->land);
        return view('inputtower', [
            'tower' => $tower,
            'land' => $land,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tower $tower)
    {
        // $request->validate([
        //     'notower' => 'required',
        //     'lat' => 'required',
        //     'towertype' => 'required',
        //     'long' => 'required',
        // ]);

        $dataTower = [
            'no' => $request->notower,
            'lat' => $request->lat,
            'long' => $request->long,
            'type' => $request->towertype,
            'description' => $request->description,
        ];

        $dataOwner = [
            "name" => $request->nama,
            "village" => $request->desa,
            "district" => $request->kecamatan,
            "regency" => $request->kabupaten,
        ];

        $dataLahan = [
            "tower_id" => $request->tower_id,
            "type" => $request->jenistanah,
            "area" => $request->luas
        ];

        $owner = LandOwner::updateOrInsert(
            [
                "name" => $request->nama,
                "village" => $request->desa,
                "district" => $request->kecamatan,
            ],
            $dataOwner
        )->get()[0];

        $land = $owner->lands()->create($dataLahan);

        $tower->where('id', $request->tower_id)->update($dataTower);
        return redirect()->action([TowerController::class, 'edit'], ['tower' => $tower, 'land' => $land]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tower $tower, Request $request)
    {
        $tower = Tower::find($request->id);
        $tower->delete();
        return redirect('/tower');
    }
}
