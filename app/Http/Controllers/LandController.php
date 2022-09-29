<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Plant;
use App\Models\Row;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all();
        $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        $towers = Tower::where('location_id', $locations->first()->id)->get();
        $rows = Row::where('location_id', $locations->first()->id)->get();
        $lands = Land::all();
        // dd($lands);
        return view('listland', [
            'title' => 'Data Lahan',
            'lands' => $lands,
            'inventories' => $inventories,
            'locations' => $locations,
            'towers' => $towers,
            'rows' => $rows,
            'script' => 'land',
        ]);
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
        $rules = [
            'nama' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'jenis' => 'required',
            'luas' => 'required',
        ];

        $request->validate($rules);

        $owner_input = [
            'name' => $request->nama,
            'village' => $request->desa,
            'district' => $request->kecamatan,
            'regency' => $request->kabupaten,
        ];

        $land_input = [
            'type' => $request->jenis,
            'area' => $request->luas,
            'user_id' => auth()->user()->id,
        ];

        if ($request->row) {
            $land_input['row_id'] = $request->row;
        }
        if ($request->tower) {
            $land_input['tower_id'] = $request->tower;
        }

        $owner = LandOwner::where('name', $request->nama)
            ->where('village', $request->desa)
            ->where('district', $request->kecamatan)
            ->where('regency', $request->kabupaten)
            ->get();

        $owner = collect($owner);

        // dd($owner['id']);

        if ($owner->isEmpty()) {
            $owner = LandOwner::create($owner_input);
            $land = $owner->lands()->create($land_input);
        } else {
            $land_input['land_owner_id'] = $owner[0]['id'];
            $land = Land::create($land_input);
        }

        return redirect('/land')->with('message', 'Input Data Lahan Berhasil');
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
        //
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

        $rules = [
            'nama' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'jenis' => 'required',
            'luas' => 'required',
        ];

        $request->validate($rules);

        $owner_input = [
            'name' => $request->nama,
            'village' => $request->desa,
            'district' => $request->kecamatan,
            'regency' => $request->kabupaten,
        ];

        $land_input = [
            'type' => $request->jenis,
            'area' => $request->luas,
            'user_id' => auth()->user()->id,
        ];

        if ($request->row) {
            $land_input['row_id'] = $request->row;
        }
        if ($request->tower) {
            $land_input['tower_id'] = $request->tower;
        }
        
        LandOwner::where('id', $request->owner_id)->update($owner_input);
        Land::where('id', $request->id)->update($land_input);
        
        return redirect('/land')->with('message', 'Update Data Lahan Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Land $land)
    {
        // DB::table('lands')
        //     ->where('id', $land->id)
        //     ->delete();

        // dd($land);
        $land->delete();
        return redirect('/land')->with('message', 'Hapus Data Lahan Berhasil');
    }
}
