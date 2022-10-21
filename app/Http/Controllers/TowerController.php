<?php

namespace App\Http\Controllers;

use App\Exports\TowersExport;
use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Tower;
use App\Models\TowerHistory;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class TowerController extends Controller
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
        $towers = Tower::all();
        
        if (auth()->user()->role == 'Surveyor') {
            $user = User::with('team')->find(auth()->user()->id);
            $inventories = Inventory::find($user->team->inventory_id);
            $locations = Location::where('inventory_id', $user->team->inventory_id)->get();
            $towers = Tower::join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', '=', $user->team->inventory_id)
                ->select('locations.id', 'inventories.*', 'towers.*')
                ->get();
        }
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

        $tmptower = $tower->where('id', $tower->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'tower_id' => $tmptower->first()->id,
            'updated' => $tmptower->first()->updated_at,
        ];

        TowerHistory::create($hist);

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

        $tower->where('id', $request->id)->update($dataTower);

        $tmptower = $tower->where('id', $tower->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'tower_id' => $tmptower->first()->id,
            'updated' => $tmptower->first()->updated_at,
        ];

        TowerHistory::create($hist);

        return redirect('/tower')->with('message', 'Update Data Tapak Tower Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tower $tower)
    {
        DB::table('towers')
            ->where('id', $tower->id)
            ->delete();
        return redirect('/tower')->with('message', 'Hapus Data Tapak Tower Berhasil');
    }

    public function print(Tower $tower)
    {
        $lands = $tower->lands;

        $villages = [];
        $districts = [];
        $regencies = [];

        foreach ($lands as $land) {
            $village = $land->owner->village;
            $district = $land->owner->district;
            $regency = $land->owner->regency;
            if (is_numeric($village) && is_numeric($district) && is_numeric($regency)) {
                $village_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/village/' . $village . '.json');

                $village = json_decode($village_api->body())->name;

                $district_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/district/' . $district . '.json');

                $district = json_decode($district_api->body())->name;

                $regency_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regency/' . $regency . '.json');

                $regency = json_decode($regency_api->body())->name;
            }
            array_push($villages, $village);
            array_push($districts, $district);
            array_push($regencies, $regency);
        }

        $pln = base64_encode(file_get_contents(public_path('/img/pln-logo.png')));
        $ptsi = base64_encode(file_get_contents(public_path('/img/logo_ptsi.png')));

        $pdf = Pdf::loadView('pdfdatatower', [
            'lands' => $lands,
            'tower' => $tower,
            'villages' => $villages,
            'districts' => $districts,
            'regencies' => $regencies,
            'pln' => $pln,
            'ptsi' => $ptsi,
        ]);

        $pdf->render();

        return $pdf->stream();
    }

    public function upload(Request $request, Tower $tower)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:60000',
        ]);

        $file = $request->file('file');
        $name = $file->hashName();

        $tower->update(['attachment' => $name]);

        $file->move('attachments', $name);

        $tmptower = $tower->where('id', $tower->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'tower_id' => $tmptower->first()->id,
            'updated' => $tmptower->first()->updated_at,
        ];

        TowerHistory::create($hist);

        return redirect('/tower')->with('message', 'Upload Lampiran Berhasil');
    }

    public function download(Tower $tower)
    {
        //how to download file on laravel?

        //PDF file is stored under project/public/attachments
        $filesource = $tower->attachment;
        $file = public_path() . '/attachments/' . $filesource;
        $filename = 'Lampiran Tower ' . $tower->no . '.pdf';

        $headers = ['Content-Type: application/pdf'];

        return response()->download($file, $filename, $headers);
    }

    public function export(Request $request)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A3:A4');
        $sheet->mergeCells('B3:B4');
        $sheet->mergeCells('C3:C4');
        $sheet->mergeCells('D3:D4');
        $sheet->mergeCells('E3:F3');
        $sheet->mergeCells('G3:K3');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $sheet->setCellValue('A1', 'REKAP DATA TAPAK TOWER');
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NO TOWER');
        $sheet->setCellValue('C3', 'RUAS JALUR');
        $sheet->setCellValue('D3', 'PEMILIK');
        $sheet->setCellValue('E3', 'TANAH');
        $sheet->setCellValue('E4', 'JENIS');
        $sheet->setCellValue('F4', 'LUAS');
        $sheet->setCellValue('G3', 'TANAM TUMBUH');
        $sheet->setCellValue('G4', 'NAMA TANAMAN');
        $sheet->setCellValue('H4', 'UMUR (th)');
        $sheet->setCellValue('I4', 'TINGGI (m)');
        $sheet->setCellValue('J4', 'DIAMETER (cm)');
        $sheet->setCellValue('K4', 'JUMLAH');

        $sheet
            ->getStyle('A1:K4')
            ->getFont()
            ->setBold(true);

        $sheet
            ->getStyle('A1:K4')
            ->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row = 5;
        $num = 1;

        $towers = Tower::all();

        foreach ($towers as $tower) {
            $sheet->setCellValue('A' . $row, $num);
            $sheet->setCellValue('B' . $row, $tower->no);
            $sheet->setCellValue('C' . $row, $tower->location->name);

            $currLand = null;

            if ($tower->lands->isEmpty()) {
                $row++;
            }
            foreach ($tower->lands as $land) {
                $prevLand = $land;

                if (!$currLand || $currLand->owner != $prevLand->owner) {
                    $sheet->setCellValue('D' . $row, $land->owner->name);
                }

                if (!$currLand || $currLand->type != $prevLand->type || $currLand->area != $prevLand->area) {
                    $sheet->setCellValue('E' . $row, $land->type);
                }
                $sheet->setCellValue('F' . $row, $land->area);

                if ($land->plants->isEmpty()) {
                    $row++;
                }
                foreach ($land->plants as $plant) {
                    $sheet->setCellValue('G' . $row, $plant->name);
                    $sheet->setCellValue('H' . $row, $plant->age);
                    $sheet->setCellValue('I' . $row, $plant->height);
                    $sheet->setCellValue('J' . $row, $plant->diameter);
                    $sheet->setCellValue('K' . $row, $plant->total);
                    $row++;
                    $currLand = $prevLand;
                }
                $currLand = $prevLand;
            }
            $num++;
        }

        $fileName = 'Rekap Data Tapak Tower.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }
}
