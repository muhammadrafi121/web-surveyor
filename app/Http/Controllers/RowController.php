<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Row;
use Illuminate\Http\Request;

class RowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Row::all();
        
        return view('listrow', [
            'title' => 'Data ROW',
            'rows' => $rows,
        ]);
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
        return view('rowbaru', [
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
        ]);

        $row = new Row();
        $row->location_id = $request->jalur;
        $row->user_id = auth()->user()->id;
        $row->save();
        return redirect('/row/' . $row->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function show(Row $row)
    {
        return $row;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function edit(Row $row, Request $request)
    {
        $land = Land::find($request->land);
        return view('inputrow', [
            'row' => $row,
            'land' => $land,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Row $row)
    {
        // $request->validate([
        //     'tower1_id' => 'required',
        //     'tower2_id' => 'required',
        //     'location_id' => 'required',
        // ]);
        // $row->where('id', $request->id)->update([
        //     'tower1_id' => $request->tower1_id,
        //     'tower2_id' => $request->tower2_id,
        //     'location_id' => $request->location_id,
        // ]);
        // return redirect('/row');

        $dataRow = [
            'tower1_id' => $request->notower1,
            'tower2_id' => $request->notower2,
        ];

        $dataOwner = [
            "name" => $request->nama,
            "village" => $request->desa,
            "district" => $request->kecamatan,
            "regency" => $request->kabupaten,
        ];

        $dataLahan = [
            "row_id" => $request->row_id,
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

        $row->where('id', $request->row_id)->update($dataRow);
        return redirect()->action([PlantController::class, 'create'], ['land' => $land]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function destroy(Row $row, Request $request)
    {
        $row = Row::find($request->id);
        $row->delete();
        return redirect('/row');
    }
}
