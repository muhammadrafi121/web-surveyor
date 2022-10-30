<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\DailyReport;
use App\Models\DailyReportHistory;
use App\Models\DailyReportImage;
use App\Models\Facility;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\ManPower;
use App\Models\Team;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;

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
        $reports = DailyReport::paginate(10);

        if (auth()->user()->role == 'Surveyor') {
            $user = User::with('team')->find(auth()->user()->id);
            $inventories = Inventory::find($user->team->inventory_id);
            $locations = Location::where('inventory_id', $user->team->inventory_id)->get();
            $teams = $user->team;
            $reports = DailyReport::where('team_id', $user->team->id)->paginate(10);
        }

        return view('listreport', [
            'title' => 'Data Daily Report',
            'reports' => $reports,
            'inventories' => $inventories,
            'locations' => $locations,
            'teams' => $teams,
            'script' => 'dailyreport',
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
        // $teams = Team::all();
        // return view('dailybaru', [
        //     'inventories' => $inventories,
        //     'locations' => $locations,
        //     'teams' => $teams
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
        $dataReport = [
            'location_id' => $request->jalur,
            'date' => $request->tanggal,
            'weather' => $request->cuaca,
            'time_start' => '08:00:00',
            'time_end' => '17:00:00',
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
                'status' => $request->koordinator == 'on' ? 1 : 0,
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

        // dd($dataReport, $dataFasilitas, $dataManPower);

        $dailyreport = DailyReport::create($dataReport);

        foreach ($dataFasilitas as $fasilitas) {
            $dailyreport->facilities()->create([
                'name' => $fasilitas['name'],
                'total' => $fasilitas['total'],
                'status' => $fasilitas['status'],
            ]);
        }

        foreach ($dataManPower as $manPower) {
            $dailyreport->manPowers()->create($manPower);
        }

        $dailyreport->activities()->create([
            'activity' => $request->kegiatan,
        ]);

        $tmpdailyreport = $dailyreport->where('id', $dailyreport->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'daily_report_id' => $tmpdailyreport->first()->id,
            'updated' => $tmpdailyreport->first()->updated_at,
        ];

        DailyReportHistory::create($hist);

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
        // return $dailyreport;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyReport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyReport $dailyreport)
    {
        // return view('inputdaily', [
        //     'dailyreport' => $dailyreport,
        // ]);
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
            'location_id' => $request->jalur,
            'date' => $request->tanggal,
            'weather' => $request->cuaca,
            'time_start' => '08:00:00',
            'time_end' => '17:00:00',
            'user_id' => auth()->user()->id,
            'team_id' => $request->tim_id,
        ];

        $dataFasilitas = [
            [
                'id' => $request->gps_id,
                'daily_report_id' => $request->id,
                'name' => 'GPS Geodetic',
                'total' => 1,
                'status' => $request->gps == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->laptop_id,
                'daily_report_id' => $request->id,
                'name' => 'Laptop',
                'total' => 1,
                'status' => $request->laptop == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->printer_id,
                'daily_report_id' => $request->id,
                'name' => 'Printer',
                'total' => 1,
                'status' => $request->printer == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->kamera_id,
                'daily_report_id' => $request->id,
                'name' => 'Kamera Digital',
                'total' => 1,
                'status' => $request->kamera == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->scanner_id,
                'daily_report_id' => $request->id,
                'name' => 'Scanner',
                'total' => 1,
                'status' => $request->scanner == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->mobil_id,
                'daily_report_id' => $request->id,
                'name' => 'Mobil',
                'total' => 1,
                'status' => $request->mobil == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->motor_id,
                'daily_report_id' => $request->id,
                'name' => 'Motor',
                'total' => 1,
                'status' => $request->motor == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->apd_id,
                'daily_report_id' => $request->id,
                'name' => 'APD',
                'total' => 1,
                'status' => $request->apd == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->atk_id,
                'daily_report_id' => $request->id,
                'name' => 'ATK',
                'total' => 1,
                'status' => $request->atk == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->cat_id,
                'daily_report_id' => $request->id,
                'name' => 'Cat Pilox',
                'total' => 1,
                'status' => $request->cat == 'on' ? 1 : 0,
            ],
        ];

        $dataManPower = [
            [
                'id' => $request->koord_id,
                'daily_report_id' => $request->id,
                'name' => 'Koordinator',
                'total' => 1,
                'status' => $request->koordinator == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->surveyor1_id,
                'daily_report_id' => $request->id,
                'name' => 'Surveyor 1',
                'total' => 1,
                'status' => $request->surveyor1 == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->surveyor2_id,
                'daily_report_id' => $request->id,
                'name' => 'Surveyor 2',
                'total' => 1,
                'status' => $request->surveyor2 == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->admin1_id,
                'daily_report_id' => $request->id,
                'name' => 'Administrator 1',
                'total' => 1,
                'status' => $request->admin1 == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->admin2_id,
                'daily_report_id' => $request->id,
                'name' => 'Administrator 2',
                'total' => 1,
                'status' => $request->admin2 == 'on' ? 1 : 0,
            ],
            [
                'id' => $request->driver_id,
                'daily_report_id' => $request->id,
                'name' => 'Driver',
                'total' => 1,
                'status' => $request->driver == 'on' ? 1 : 0,
            ],
        ];

        foreach ($dataFasilitas as $fasilitas) {
            Facility::where('id', $fasilitas['id'])->update($fasilitas);
        }

        foreach ($dataManPower as $manPower) {
            ManPower::where('id', $manPower['id'])->update($manPower);
        }

        Activity::where('id', $request->kegiatan_id)->update([
            'daily_report_id' => $request->id,
            'activity' => $request->kegiatan,
        ]);

        $dailyreport->where('id', $request->id)->update($dataReport);

        $tmpdailyreport = $dailyreport->where('id', $dailyreport->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'daily_report_id' => $tmpdailyreport->first()->id,
            'updated' => $tmpdailyreport->first()->updated_at,
        ];

        DailyReportHistory::create($hist);

        return redirect('/dailyreport')->with('message', 'Update Data Daily Report Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyReport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyReport $dailyreport)
    {
        $dailyreport->delete();
        return redirect('/dailyreport')->with('message', 'Hapus Data Daily Report Berhasil');
    }

    public function print(DailyReport $dailyreport)
    {
        $pln = base64_encode(file_get_contents(public_path('/img/Logo_PLN.png')));
        $ptsi = base64_encode(file_get_contents(public_path('/img/logo_ptsi.png')));

        $img1 = null;
        $img2 = null;
        if (File::exists(public_path('report-imgs/' . $dailyreport->images[0]->name))) {
            $img1 = base64_encode(file_get_contents(public_path('/report-imgs/' . $dailyreport->images[0]->name)));
        }
        if (File::exists(public_path('report-imgs/' . $dailyreport->images[1]->name))) {
            $img2 = base64_encode(file_get_contents(public_path('/report-imgs/' . $dailyreport->images[1]->name)));
        }

        $inv = $dailyreport->location->inventory->name;
        $pieces = explode(' ', $inv);
        $no_inv = array_pop($pieces);

        $pdf = Pdf::loadView('pdfdatareport', [
            'pln' => $pln,
            'ptsi' => $ptsi,
            'img1' => $img1,
            'img2' => $img2,
            'report' => $dailyreport,
            'no_inv' => $no_inv,
        ]);

        $pdf->render();

        return $pdf->stream();
    }

    public function upload(Request $request, DailyReport $dailyreport)
    {
        $this->validate($request, [
            'foto1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'foto2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $image1 = $request->file('foto1');
        $image1Name = $image1->hashName();

        $destinationPath = public_path('/report-imgs');
        $img = Image::make($image1->path());
        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image1Name);

        $image2 = $request->file('foto2');
        $image2Name = $image2->hashName();

        $destinationPath = public_path('/report-imgs');
        $img = Image::make($image2->path());
        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image2Name);

        if ($dailyreport->images->isEmpty()) {
            $dailyreport->images()->create(['name' => $image1Name]);
            $dailyreport->images()->create(['name' => $image2Name]);
        } else {
            if (File::exists(public_path('report-imgs/' . $dailyreport->images[0]->name))) {
                File::delete(public_path('report-imgs/' . $dailyreport->images[0]->name));
            }
            if (File::exists(public_path('report-imgs/' . $dailyreport->images[1]->name))) {
                File::delete(public_path('report-imgs/' . $dailyreport->images[1]->name));
            }

            DailyReportImage::where('id', $dailyreport->images[0]->id)->update(['name' => $image1Name]);
            DailyReportImage::where('id', $dailyreport->images[1]->id)->update(['name' => $image2Name]);
        }

        return redirect('/dailyreport')->with('message', 'Upload Lampiran Daily Report Berhasil');
    }
}
