<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\DailyReport;
use App\Models\Facility;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\ManPower;
use App\Models\Team;
use Illuminate\Http\Request;

class DailyReportController extends Controller
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
        $teams = Team::where('inventory_id', $inventories->first()->id)->get();
        return view('listreport', [
            'title' => 'Data Daily Report',
            'reports' => DailyReport::all(),
            'inventories' => $inventories,
            'locations' => $locations,
            'teams' => $teams,
            'script' => 'dailyreport'
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
        $teams = Team::all();
        return view('dailybaru', [
            'inventories' => $inventories,
            'locations' => $locations,
            'teams' => $teams
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
        $dataReport = [
            'location_id' => $request->jalur,
            'date' => $request->tanggal,
            'weather' => $request->cuaca,
            'time_start' => $request->waktum,
            'time_end' => $request->waktus,
            'user_id' => auth()->user()->id,
            'team_id' => $request->tim_id,
        ];

        $dataFasilitas = [
            [
                'name' => 'GPS Geodetic',
                'total' => 1,
                'status' => $request->gps == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Laptop',
                'total' => 1,
                'status' => $request->laptop == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Printer',
                'total' => 1,
                'status' => $request->printer == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Kamera Digital',
                'total' => 1,
                'status' => $request->kamera == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Scanner',
                'total' => 1,
                'status' => $request->scanner == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Mobil',
                'total' => 1,
                'status' => $request->mobil == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Motor',
                'total' => 1,
                'status' => $request->motor == 'on' ? 1 : 0,
            ],
            [
                'name' => 'APD',
                'total' => 1,
                'status' => $request->apd == 'on' ? 1 : 0,
            ],
            [
                'name' => 'ATK',
                'total' => 1,
                'status' => $request->atk == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Cat Pilox',
                'total' => 1,
                'status' => $request->cat == 'on' ? 1 : 0,
            ],
        ];

        $dataManPower = [
            [
                'name' => 'Kordinator',
                'total' => 1,
                'status' => $request->kordinator == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Surveyor 1',
                'total' => 1,
                'status' => $request->surveyor1 == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Surveyor 2',
                'total' => 1,
                'status' => $request->surveyor2 == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Administrator 1',
                'total' => 1,
                'status' => $request->admin1 == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Administrator 2',
                'total' => 1,
                'status' => $request->admin2 == 'on' ? 1 : 0,
            ],
            [
                'name' => 'Driver',
                'total' => 1,
                'status' => $request->driver == 'on' ? 1 : 0,
            ],
        ];

        $dailyreport = DailyReport::create($dataReport);

        foreach ($dataFasilitas as $fasilitas) {
            $dailyreport->facilities()->create($fasilitas);
        }

        foreach ($dataManPower as $manPower) {
            $dailyreport->manPowers()->create($manPower);
        }
        
        $dailyreport->activities()->create([
            'activity' => $request->kegiatan,
        ]);

        return redirect('/dailyreport')->with('message', 'Input Data Daily Report Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyReport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function show(DailyReport $dailyreport)
    {
        return $dailyreport;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyReport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyReport $dailyreport)
    {
        return view('inputdaily', [
            'dailyreport' => $dailyreport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyReport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyReport $dailyreport)
    {
        $dataReport = [
            'weather' => $request->cuaca,
            'time_start' => $request->waktum,
            'time_end' => $request->waktus,
        ];

        $dataFasilitas = [
            [
                'dailyreport_id' => $request->id,
                'name' => 'GPS Geodetic',
                'total' => 1,
                'status' => $request->gps,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Laptop',
                'total' => 1,
                'status' => $request->laptop,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Printer',
                'total' => 1,
                'status' => $request->printer,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Kamera Digital',
                'total' => 1,
                'status' => $request->kamera,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Scanner',
                'total' => 1,
                'status' => $request->scanner,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Mobil',
                'total' => 1,
                'status' => $request->mobil,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Motor',
                'total' => 1,
                'status' => $request->motor,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'APD',
                'total' => 1,
                'status' => $request->apd,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'ATK',
                'total' => 1,
                'status' => $request->atk,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Cat Pilox',
                'total' => 1,
                'status' => $request->cat,
            ],
        ];

        $dataManPower = [
            [
                'dailyreport_id' => $request->id,
                'name' => 'Kordinator',
                'total' => 1,
                'status' => $request->kordinator,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Surveyor 1',
                'total' => 1,
                'status' => $request->surveyor1,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Surveyor 2',
                'total' => 1,
                'status' => $request->surveyor2,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Administrator 1',
                'total' => 1,
                'status' => $request->admin1,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Administrator 2',
                'total' => 1,
                'status' => $request->admin2,
            ],
            [
                'dailyreport_id' => $request->id,
                'name' => 'Driver',
                'total' => 1,
                'status' => $request->driver,
            ],
        ];

        foreach ($dataFasilitas as $fasilitas) {
            Facility::create($fasilitas);
        }

        foreach ($dataManPower as $manPower) {
            ManPower::create($manPower);
        }
        
        Activity::create([
            'dailyreport_id' => $request->id,
            'activity' => $request->kegiatan,
        ]);

        $dailyreport->where('id', $request->id)->update($dataReport);
        return redirect('/dailyreport');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyReport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyReport $dailyreport)
    {
        //
    }
}
