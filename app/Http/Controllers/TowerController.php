<?php

namespace App\Http\Controllers;

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
            'token' => csrf_token(),
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
            'no' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'type' => 'required',
            'location_id' => 'required',
        ]);

        $tower = new Tower();
        $tower->location_id = $request->location_id;
        $tower->no = $request->no;
        $tower->type = $request->type;
        $tower->lat = $request->lat;
        $tower->long = $request->long;
        $tower->description = $request->description;
        $tower->save();
        return redirect('/tower');
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
        return $tower->find($request->id);
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
            'no' => 'required',
            'lat' => 'required',
            'type' => 'required',
            'long' => 'required',
            'location_id' => 'required',
        ]);
        $tower->where('id', $request->id)->update([
            'no' => $request->no,
            'lat' => $request->lat,
            'long' => $request->long,
            'type' => $request->type,
            'location_id' => $request->location_id,
            'description' => $request->description,
        ]);
        return redirect('/tower');
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
