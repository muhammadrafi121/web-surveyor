<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Plant;
use Illuminate\Http\Request;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lands = Land::with('owner');
        return [
            'lands' => $lands,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
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
            'owner_name' => 'required',
            'village' => 'required',
            'district' => 'required',
            'regency' => 'required',
            'province' => 'required',
            'type' => 'required',
            'area' => 'required',
            'location_id' => 'required',
        ]);

        $owner_input = [
            'name' => $request->owner_name,
            'village' => $request->village,
            'district' => $request->district,
            'regency' => $request->regency,
            'province' => $request->province,
        ];

        $land_input = [
            'location_id' => $request->location_id,
            'owner_id' => $request->owner_id,
            'type' => $request->type,
            'area' => $request->area,
            'description' => $request->description,
        ];

        if ($request->owner_id) {
            $owner = LandOwner::find('id', $request->owner_id);
        } else {
            $owner = LandOwner::create($owner_input);
        }

        $land = $owner->lands()->create($land_input);
        return redirect('/land');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Land $land)
    {
        return $land->with(['owner', 'plants'])->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Land $land, Request $request)
    {
        $tower = $land->tower;
        $row = $land->row;
        if ($tower) {
            return view('inputtower', [
                'tower' => $tower,
                'land' => $land,
            ]);
        } else {
            return view('inputrow', [
                'row' => $row,
                'land' => $land,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Land $land)
    {
        // $request->validate([
        //     'owner_name' => 'required',
        //     'village' => 'required',
        //     'district' => 'required',
        //     'regency' => 'required',
        //     'province' => 'required',
        //     'type' => 'required',
        //     'area' => 'required',
        //     'location_id' => 'required',
        // ]);

        // $owner_input = [
        //     'name' => $request->owner_name,
        //     'village' => $request->village,
        //     'district' => $request->district,
        //     'regency' => $request->regency,
        //     'province' => $request->province,
        // ];

        // $land_input = [
        //     'location_id' => $request->location_id,
        //     'type' => $request->type,
        //     'area' => $request->area,
        //     'description' => $request->description,
        // ];

        // if ($request->row_id) {
        //     $land_input['row_id'] = $request->row_id;
        // }

        // if ($request->tower_id) {
        //     $land_input['tower_id'] = $request->tower_id;
        // }

        // if ($request->owner_id) {
        //     $owner = LandOwner::find('id', $request->owner_id);
        // } else {
        //     $owner = LandOwner::create($owner_input);
        // }

        // $land = $owner->lands()->where('id', $request->id)->update($land_input);

        $plantData = [
            'land_id' => $request->land_id,
            'name' => $request->namatanaman,
            'age' => $request->umur,
            'height' => $request->tinggi,
            'diameter' => $request->diameter,
            'total' => $request->jumlah,
            'description' => $request->keterangan,
        ];

        $plant = Plant::create($plantData);

        // dd($plant);

        return redirect('/land/' . $plant->land_id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
