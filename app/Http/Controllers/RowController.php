<?php

namespace App\Http\Controllers;

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
        return [
            'token' => csrf_token(),
            'rows' => $rows,
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
            'tower1_id' => 'required',
            'tower2_id' => 'required',
            'location_id' => 'required',
        ]);

        $row = new Row();
        $row->tower1_id = $request->tower1_id;
        $row->tower2_id = $request->tower2_id;
        $row->location_id = $request->location_id;
        $row->save();
        return redirect('/row');
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
        return $row->find($request->id);
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
            'tower1_id' => 'required',
            'tower2_id' => 'required',
            'location_id' => 'required',
        ]);
        $row->where('id', $request->id)->update([
            'tower1_id' => $request->tower1_id,
            'tower2_id' => $request->tower2_id,
            'location_id' => $request->location_id,
        ]);
        return redirect('/row');
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
