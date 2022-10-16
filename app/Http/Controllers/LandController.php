<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Plant;
use App\Models\Row;
use App\Models\Tower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all();
        if (auth()->user()->role == 'Surveyor') {
            $user = User::with('team')->find(auth()->user()->id);
            $inventories = Inventory::find($user->team->inventory_id);
        }

        $locations = Location::where('inventory_id', $inventories->first()->id)->get();
        $towers = Tower::where('location_id', $locations->first()->id)->get();
        $rows = Row::where('location_id', $locations->first()->id)->get();
        $lands = Land::all();
        if (auth()->user()->role == 'Surveyor') {
            $user = User::with('team')->find(auth()->user()->id);
            $towerlands = Land::join('towers', 'lands.tower_id', '=', 'towers.id')
                ->join('locations', 'towers.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', '=', $user->team->inventory_id)
                ->select('locations.id', 'inventories.*', 'lands.*');
            $rowlands = Land::join('rows', 'lands.row_id', '=', 'rows.id')
                ->join('locations', 'rows.location_id', '=', 'locations.id')
                ->join('inventories', 'locations.inventory_id', '=', 'inventories.id')
                ->where('inventories.id', '=', $user->team->inventory_id)
                ->select('locations.id', 'inventories.*', 'lands.*');
            // dd($towerlands->get(), $rowlands->get());
            $lands = $towerlands->union($rowlands)->get();
        }
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
        // $request->validate([
        //     'owner_name' => 'required',
        //     'village' => 'required',
        //     'district' => 'required',
        //     'regency' => 'required',
        //     'province' => 'required',
        //     'type' => 'required',
        //     'area' => 'required',
        //     'location_id' => 'required',
        // ]);

        // $owner_input = [
        //     'name' => $request->owner_name,
        //     'village' => $request->village,
        //     'district' => $request->district,
        //     'regency' => $request->regency,
        //     'province' => $request->province,
        // ];

        // $land_input = [
        //     'location_id' => $request->location_id,
        //     'type' => $request->type,
        //     'area' => $request->area,
        //     'description' => $request->description,
        // ];

        // if ($request->row_id) {
        //     $land_input['row_id'] = $request->row_id;
        // }

        // if ($request->tower_id) {
        //     $land_input['tower_id'] = $request->tower_id;
        // }

        // if ($request->owner_id) {
        //     $owner = LandOwner::find('id', $request->owner_id);
        // } else {
        //     $owner = LandOwner::create($owner_input);
        // }

        // $land = $owner->lands()->where('id', $request->id)->update($land_input);

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
        Land::where('id', $request->id)->update($land_input);

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

        return view('pdfdatalahan', [
            'land' => $land,
            'tower' => $tower,
            'row' => $row,
        ]);
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
}
