<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandHistory;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Plant;
use App\Models\Row;
use App\Models\Tower;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $paginate = 10;

        $inventories = Inventory::all();
        if (auth()->user()->role == 'Surveyor') {
            $user = User::with('team')->find(auth()->user()->id);
            $inventories = Inventory::find($user->team->inventory_id);
        }

        $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        $towers = Tower::where('location_id', $locations->first()->id)->get();
        $rows = Row::where('location_id', $locations->first()->id)->get();

        $towerlands = Land::with([
            'tower' => function ($q) {
                $q->orderBy('no', 'asc');
            },
        ]);
        $rowlands = Land::with([
            'row.firsttower' => function ($q) {
                $q->orderBy('no', 'asc');
            },
        ]);

        if (auth()->user()->role == 'Surveyor') {
            $user = User::with('team')->find(auth()->user()->id);
            $towerlands = Land::join('towers', 'lands.tower_id', '=', 'towers.id')
                ->join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', '=', $user->team->inventory_id)
                ->select('locations.id', 'inventories.*', 'lands.*')
                ->orderBy('towers.no', 'asc');
            $rowlands = Land::join('rows', 'lands.row_id', '=', 'rows.id')
                ->join('locations', 'rows.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', '=', $user->team->inventory_id)
                ->select('locations.id', 'inventories.*', 'lands.*')
                ->with([
                    'rows.firsttower' => function ($q) {
                        $q->orderBy('no', 'asc');
                    },
                ]);
            // dd($towerlands->get(), $rowlands->get());

        }
        
        $allLands = $towerlands->union($rowlands)->get();
        $lands = $this->paginate($allLands);
        $lands->withPath('/land');

        return view('listland', [
            'title' => 'Data Lahan',
            'lands' => $lands,
            'inventories' => $inventories,
            'locations' => $locations,
            'towers' => $towers,
            'rows' => $rows,
            'script' => 'land',
        ]);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $rules = [
            'nama' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'jenis' => 'required',
            'luas' => 'required',
        ];

        $request->validate($rules);

        $owner_input = [
            'name' => $request->nama,
            'village' => $request->desa,
            'district' => $request->kecamatan,
            'regency' => $request->kabupaten,
        ];

        $land_input = [
            'type' => $request->jenis,
            'area' => $request->luas,
            'user_id' => auth()->user()->id,
        ];

        if ($request->row) {
            $land_input['row_id'] = $request->row;
        }
        if ($request->tower) {
            $land_input['tower_id'] = $request->tower;
        }

        $owner = LandOwner::where('name', $request->nama)
            ->where('village', $request->desa)
            ->where('district', $request->kecamatan)
            ->where('regency', $request->kabupaten)
            ->get();

        $owner = collect($owner);

        // dd($owner['id']);

        if ($owner->isEmpty()) {
            $owner = LandOwner::create($owner_input);
            $land = $owner->lands()->create($land_input);
        } else {
            $land_input['land_owner_id'] = $owner[0]['id'];
            $land = Land::create($land_input);
        }

        $tmpland = $land->where('id', $land->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'land_id' => $tmpland->first()->id,
            'updated' => $tmpland->first()->updated_at,
        ];

        LandHistory::create($hist);

        return redirect('/land')->with('message', 'Input Data Lahan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Land $land)
    {
        return $land->with(['owner', 'plants'])->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Land $land, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Land $land)
    {
        $rules = [
            'nama' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'jenis' => 'required',
            'luas' => 'required',
        ];

        $request->validate($rules);

        $owner_input = [
            'name' => $request->nama,
            'village' => $request->desa,
            'district' => $request->kecamatan,
            'regency' => $request->kabupaten,
        ];

        $land_input = [
            'type' => $request->jenis,
            'area' => $request->luas,
            'user_id' => auth()->user()->id,
        ];

        if ($request->row) {
            $land_input['row_id'] = $request->row;
        }
        if ($request->tower) {
            $land_input['tower_id'] = $request->tower;
        }

        LandOwner::where('id', $request->owner_id)->update($owner_input);
        $land->where('id', $request->id)->update($land_input);

        $tmpland = $land->where('id', $land->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'land_id' => $tmpland->first()->id,
            'updated' => $tmpland->first()->updated_at,
        ];

        LandHistory::create($hist);

        return redirect('/land')->with('message', 'Update Data Lahan Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Land $land)
    {
        // DB::table('lands')
        //     ->where('id', $land->id)
        //     ->delete();

        // dd($land);
        $land->delete();
        return redirect('/land')->with('message', 'Hapus Data Lahan Berhasil');
    }

    public function print(Land $land)
    {
        $row = $land->row()->with('location');
        $tower = $land->tower()->with('location');

        $village = $land->owner->village;
        $district = $land->owner->district;
        $regency = $land->owner->regency;

        if (is_numeric($village) && is_numeric($district) && is_numeric($regency)) {
            $village_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/village/' . $land->owner->village . '.json');

            $village = json_decode($village_api->body())->name;

            $district_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/district/' . $land->owner->district . '.json');

            $district = json_decode($district_api->body())->name;

            $regency_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regency/' . $land->owner->regency . '.json');

            $regency = json_decode($regency_api->body())->name;
        }

        $pln = base64_encode(file_get_contents(public_path('/img/pln-logo.png')));
        $ptsi = base64_encode(file_get_contents(public_path('/img/logo_ptsi.png')));

        $pdf = Pdf::loadView('pdfdatalahan', [
            'land' => $land,
            'tower' => $tower,
            'row' => $row,
            'village' => $village,
            'district' => $district,
            'regency' => $regency,
            'pln' => $pln,
            'ptsi' => $ptsi,
        ]);

        $pdf->render();

        return $pdf->stream();
    }

    public function upload(Request $request, Land $land)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:60000',
        ]);

        $file = $request->file('file');
        $name = $file->hashName();

        $land->update(['attachment' => $name]);

        $file->move('attachments', $name);

        $tmpland = $land->where('id', $land->id)->get();

        $hist = [
            'user_id' => auth()->user()->id,
            'land_id' => $tmpland->first()->id,
            'updated' => $tmpland->first()->updated_at,
        ];

        LandHistory::create($hist);

        return redirect('/land')->with('message', 'Upload Lampiran Berhasil');
    }

    public function download(Land $land)
    {
        //how to download file on laravel?

        //PDF file is stored under project/public/attachments
        $filesource = $land->attachment;
        $file = public_path() . '/attachments/' . $filesource;
        $filename = 'Lampiran Lahan Milik ' . $land->owner->name . '.pdf';

        $headers = ['Content-Type: application/pdf'];

        return response()->download($file, $filename, $headers);
    }

    public function format()
    {
        //how to download file on laravel?
        $file = public_path() . '/format/land.xlsx';
        $filename = 'Format Import Lahan.xlsx';

        $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

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

        $sheet->setCellValue('A1', 'REKAP DATA LAHAN');
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

        $lands = Land::orderBy('land_owner_id')->get();

        $currLand = null;
        $currNo = null;
        $currLoc = null;
        foreach ($lands as $land) {
            $prevLand = $land;

            $no = $land->row ? $land->row->firsttower->no . ' - ' . $land->row->secondtower->no : $land->tower->no;
            $location = $land->row ? $land->row->location->name : $land->tower->location->name;

            $prevNo = $no;
            $prevLoc = $location;

            if ($currNo != $prevNo) {
                $sheet->setCellValue('A' . $row, $num);
                $sheet->setCellValue('B' . $row, $no);
            }

            if ($currLoc != $prevLoc) {
                $sheet->setCellValue('C' . $row, $location);
            }

            if (!$currLand || $currLand->owner != $prevLand->owner) {
                $sheet->setCellValue('D' . $row, $land->owner->name);
            }

            if (!$currLand || $currLand->type != $prevLand->type) {
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
            $currNo = $prevNo;
            $currLoc = $prevLoc;
            $num++;
        }

        $fileName = 'Rekap Data Lahan.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    public function import(Request $request)
    {
        $spreadsheet = IOFactory::load($request->file);
        $sheet = $spreadsheet->getActiveSheet();

        $num = 5;

        $lands = [];

        $province_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/provinces.json');

        $provinces = json_decode($province_api->body());

        while ($sheet->getCell('B' . $num)->getValue() != null) {
            $land = [];

            $towers = explode(' - ', $sheet->getCell('B' . $num)->getValue());
            $location = Location::where('name', $sheet->getCell('C' . $num)->getValue())->first();

            $firsttower = Tower::where('no', $towers[0])
                ->where('location_id', $location->id)
                ->first();

            // dd($firsttower['id']);

            $land['tower_id'] = $firsttower->id;
            $land['row_id'] = null;

            if (count($towers) == 2) {
                $secondtower = Tower::where('no', $towers[1])
                    ->where('location_id', $location->id)
                    ->first();
                $row = Row::where('tower1_id', $firsttower->id)
                    ->where('tower2_id', $secondtower->id)
                    ->first();

                $land['row_id'] = $row->id;
                $land['tower_id'] = null;
            }

            $land['owner_name'] = $sheet->getCell('D' . $num)->getValue();

            $owner_province = $sheet->getCell('H' . $num)->getValue();
            $province_id = null;
            foreach ($provinces as $province) {
                if ($province->name == $owner_province) {
                    $province_id = $province->id;
                    break;
                }
            }

            $regency_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/regencies/' . $province_id . '.json');

            $regencies = json_decode($regency_api->body());

            foreach ($regencies as $regency) {
                if ($regency->name == $sheet->getCell('G' . $num)->getValue()) {
                    $land['regency'] = $regency->id;
                    break;
                }
            }

            $district_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/districts/' . $land['regency'] . '.json');

            $districts = json_decode($district_api->body());

            foreach ($districts as $district) {
                if ($district->name == $sheet->getCell('F' . $num)->getValue()) {
                    $land['district'] = $district->id;
                    break;
                }
            }

            $village_api = Http::get('https://muhammadrafi121.github.io/api-wilayah-indonesia/api/villages/' . $land['district'] . '.json');

            $villages = json_decode($village_api->body());

            foreach ($villages as $village) {
                if ($village->name == $sheet->getCell('E' . $num)->getValue()) {
                    $land['village'] = $village->id;
                    break;
                }
            }

            $land['type'] = $sheet->getCell('I' . $num)->getValue();
            $land['area'] = $sheet->getCell('J' . $num)->getValue();
            $land['plant'] = $sheet->getCell('K' . $num)->getValue();
            $land['age'] = $sheet->getCell('L' . $num)->getValue();
            $land['height'] = $sheet->getCell('M' . $num)->getValue();
            $land['diameter'] = $sheet->getCell('N' . $num)->getValue();
            $land['total'] = $sheet->getCell('O' . $num)->getValue();
            $land['user_id'] = auth()->user()->id;

            array_push($lands, $land);

            $num++;
        }

        foreach ($lands as $land) {
            $owner = LandOwner::where('name', $land['owner_name'])
                ->where('village', $land['village'])
                ->where('district', $land['district'])
                ->where('regency', $land['regency'])
                ->get();

            $owner = collect($owner);

            $land_input = [
                'row_id' => $land['row_id'],
                'tower_id' => $land['tower_id'],
                'type' => $land['type'],
                'area' => $land['area'],
                'user_id' => $land['user_id'],
            ];

            if ($owner->isEmpty()) {
                $owner_input = [
                    'name' => $land['owner_name'],
                    'village' => $land['village'],
                    'district' => $land['district'],
                    'regency' => $land['regency'],
                ];
                $owner = LandOwner::create($owner_input);
                $landData = $owner->lands()->create($land_input);
            } else {
                $land_input['land_owner_id'] = $owner[0]['id'];

                $tmpLand = Land::where('type', $land['type'])
                    ->where('area', $land['area'])
                    ->where('land_owner_id', $land_input['land_owner_id'])
                    ->get();

                if ($tmpLand->isEmpty()) {
                    $landData = Land::create($land_input);
                } else {
                    $landData = $tmpLand->first();
                }
            }

            if ($land['plant']) {
                $plant_input = [
                    'name' => $land['plant'],
                    'age' => $land['age'],
                    'height' => $land['height'],
                    'diameter' => $land['diameter'],
                    'total' => $land['total'],
                ];

                $landData->plants()->create($plant_input);
            }
        }

        return redirect('/land')->with('message', 'Import Data Lahan Berhasil');
    }
}
