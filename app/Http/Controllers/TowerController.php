<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
        $inventories = Inventory::all();
        $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        return view('listtower', [
            'title' => 'Data Tapak Tower',
            'towers' => $towers,
            'inventories' => $inventories,
            'locations' => $locations,
            'script' => 'tower',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $inventories = Inventory::all();
        // $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        // return view('towerbaru', [
        //     'title' => 'Data Tapak Tower',
        //     'inventories' => $inventories,
        //     'locations' => $locations
        // ]);
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
            'lat' => 'required',
            'long' => 'required',
            'type' => 'required',
        ]);

        $tower = new Tower();
        $tower->location_id = $request->jalur;
        $tower->no = $request->tapak;
        $tower->lat = $request->lat;
        $tower->long = $request->long;
        $tower->type = $request->type;
        $tower->user_id = auth()->user()->id;
        $tower->save();
        return redirect('/tower')->with('message', 'Input Data Tapak Tower Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function show(Tower $tower)
    {
        // return $tower;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function edit(Tower $tower, Request $request)
    {
        // $land = Land::find($request->land);
        // return view('inputtower', [
        //     'title' => 'Data Tapak Tower',
        //     'tower' => $tower,
        //     'land' => $land,
        // ]);
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
        $request->validate([
            'jalur' => 'required',
            'tapak' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'type' => 'required',
        ]);

        $dataTower = [
            'no' => $request->tapak,
            'location_id' => $request->jalur,
            'lat' => $request->lat,
            'long' => $request->long,
            'type' => $request->type,
            'user_id' => auth()->user()->id,
        ];

        // $dataOwner = [
        //     "name" => $request->nama,
        //     "village" => $request->desa,
        //     "district" => $request->kecamatan,
        //     "regency" => $request->kabupaten,
        // ];

        // $dataLahan = [
        //     "tower_id" => $request->tower_id,
        //     "type" => $request->jenistanah,
        //     "area" => $request->luas
        // ];

        // $owner = LandOwner::updateOrInsert(
        //     [
        //         "name" => $request->nama,
        //         "village" => $request->desa,
        //         "district" => $request->kecamatan,
        //     ],
        //     $dataOwner
        // )->get()[0];

        // $land = $owner->lands()->create($dataLahan);

        $tower->where('id', $request->id)->update($dataTower);
        return redirect('/tower')->with('message', 'Update Data Tapak Tower Berhasil');
        // return redirect()->action([PlantController::class, 'create'], ['land' => $land]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tower $tower)
    {
        DB::table('towers')->where('id', $tower->id)->delete();
        return redirect('/tower')->with('message', 'Hapus Data Tapak Tower Berhasil');
    }

    public function upload(Request $request, Tower $tower)
    {
        $request->validate([
            'file' => "required|mimes:pdf|max:60000"
        ]);

        $file = $request->file('file');
        $name = $file->hashName();
        
        $tower->update(["attachment" => $name]);

        $file->move('attachments', $name);


        return redirect('/tower')->with('message', 'Upload Lampiran Berhasil');
    }

    public function download(Tower $tower)
    {
        //how to download file on laravel?
        
        //PDF file is stored under project/public/attachments
        $filesource = $tower->attachment;
        $file = public_path(). "/attachments/" . $filesource;
        $filename = "Lampiran Tower " . $tower->no . ".pdf";

        $headers = array(
                'Content-Type: application/pdf',
                );

        return response()->download($file, $filename, $headers);

    }
}
