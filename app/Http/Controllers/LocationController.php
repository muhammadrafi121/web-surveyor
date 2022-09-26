<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('listlocation', [
            'title' => 'Data Jalur',
            'inventories' => Inventory::all(),
            'locations' => Location::all(),
            'script' => 'location',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        Location::create([
            'inventory_id' => $request->wilayah,
            'name' => $request->name,
        ]);

        return redirect('/location')->with('message', 'Input Data Jalur Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'wilayah' => 'required',
            'name' => 'required',
        ]);

        $location->where('id', $request->id)->update([
            'inventory_id' => $request->wilayah,
            'name' => $request->name
        ]);

        return redirect('/location')->with('message', 'Update Data Jalur Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        DB::table('locations')->where('id', $location->id)->delete();
        return redirect('/location');
    }
}
