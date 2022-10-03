<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $land = Land::find($request->land);
        return view('inputtanaman', [
            'land' => $land,
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
        $plantData = [];
        $plantDataEdit = [];
        $plantDataDelete = [];

        for ($i = 0; $i < sizeof($request->namatanaman); $i++) {
            if ($request->namatanaman[$i] != null) {
                if ($request->idtanaman[$i] == null) {
                    $plantData[] = [
                        'land_id' => $request->id_lahan,
                        'name' => $request->namatanaman[$i],
                        'age' => $request->umurtanaman[$i],
                        'height' => $request->tinggitanaman[$i],
                        'diameter' => $request->diametertanaman[$i],
                        'total' => $request->jumlahtanaman[$i],
                    ];
                } else {
                    $plantDataEdit[] = [
                        'id' => $request->idtanaman[$i],
                        'land_id' => $request->id_lahan,
                        'name' => $request->namatanaman[$i],
                        'age' => $request->umurtanaman[$i],
                        'height' => $request->tinggitanaman[$i],
                        'diameter' => $request->diametertanaman[$i],
                        'total' => $request->jumlahtanaman[$i],
                    ];
                }
            } else if ($request->idtanaman[$i] != null) {
                $plantDataDelete[] = [
                    'id' => $request->idtanaman[$i]
                ];
            }
        }

        foreach ($plantData as $plant) {
            Plant::create($plant);
        }

        foreach ($plantDataEdit as $edit) {
            Plant::where('id', $edit['id'])->update($edit);
        }

        foreach ($plantDataDelete as $delete) {
            Plant::where('id', $delete['id'])->delete();
        }

        return redirect('/land')->with('message', 'Update Data Tanaman Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function edit(Plant $plant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plant $plant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plant $plant)
    {
        //
    }
}
