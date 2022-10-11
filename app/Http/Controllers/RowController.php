<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Row;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $inventories = Inventory::all();
        $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        $towers = Tower::where('location_id', $locations->first()->id)->get();
        return view('listrow', [
            'title' => 'Data ROW',
            'rows' => $rows,
            'inventories' => $inventories,
            'locations' => $locations,
            'towers' => $towers,
            'script' => 'row',
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
        // return view('rowbaru', [
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
            'notower1' => 'required',
            'notower2' => 'required',
        ]);

        $row = new Row();
        $row->location_id = $request->jalur;
        $row->tower1_id = $request->notower1;
        $row->tower2_id = $request->notower2;
        $row->user_id = auth()->user()->id;
        $row->save();
        return redirect('/row')->with('message', 'Input Data RoW Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function show(Row $row)
    {
        // return $row;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function edit(Row $row, Request $request)
    {
        // $land = Land::find($request->land);
        // return view('inputrow', [
        //     'row' => $row,
        //     'land' => $land,
        // ]);
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
        $request->validate([
            'jalur' => 'required',
            'notower1' => 'required',
            'notower2' => 'required',
        ]);

        $row->where('id', $request->id)->update([
            'tower1_id' => $request->notower1,
            'tower2_id' => $request->notower2,
            'location_id' => $request->jalur,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/row')->with('message', 'Update Data RoW Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Row  $row
     * @return \Illuminate\Http\Response
     */
    public function destroy(Row $row)
    {
        DB::table('rows')->where('id', $row->id)->delete();
        return redirect('/row')->with('message', 'Hapus Data RoW Berhasil');
    }

    public function upload(Request $request, Row $row)
    {
        $request->validate([
            'file' => "required|mimes:pdf|max:60000"
        ]);

        $file = $request->file('file');
        $name = $file->hashName();
        
        $row->update(["attachment" => $name]);

        $file->move('attachments', $name);


        return redirect('/row')->with('message', 'Upload Lampiran Berhasil');
    }

    public function download(Row $row)
    {
        //how to download file on laravel?
        
        //PDF file is stored under project/public/attachments
        $filesource = $row->attachment;
        $file = public_path(). "/attachments/" . $filesource;
        $filename = "Lampiran RoW " . $row->firsttower->no . "-" . $row->secondtower->no . ".pdf";

        $headers = array(
                'Content-Type: application/pdf',
                );

        return response()->download($file, $filename, $headers);

    }
}
