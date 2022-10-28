<?php

namespace App\Http\Controllers;

use App\Models\Land;
use App\Models\LandOwner;
use App\Models\Location;
use App\Models\Row;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ToolController extends Controller
{
    public function index()
    {
        return view('tool', [
            'title' => 'Alat',
            'script' => 'tool'
        ]);
    }

    public function import(Request $request)
    {
        if ($request->jenis == 'tower') {
            $this->importTower($request);
            return redirect('/tool')->with('message', 'Import Data Tapak Tower Berhasil');
        }
        if ($request->jenis == 'row') {
            $this->importRow($request);
            return redirect('/tool')->with('message', 'Import Data RoW Berhasil');
        }
        if ($request->jenis == 'lahan') {
            $this->importLahan($request);
            return redirect('/tool')->with('message', 'Import Data Lahan Berhasil');
        }
    }

    public function export(Request $request)
    {
        if ($request->jenis == 'tower') {
            $this->exportTower($request);
            return redirect('/tool');
        }
        if ($request->jenis == 'row') {
            $this->exportRow($request);
            return redirect('/tool');
        }
        if ($request->jenis == 'lahan') {
            $this->exportLahan($request);
            return redirect('/tool');
        }
    }

    // Ekspor dan Impor Data Tapak Tower

    public function exportTower(Request $request)
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
    
    public function importTower(Request $request)
    {
        $spreadsheet = IOFactory::load($request->file);
        $sheet = $spreadsheet->getActiveSheet();

        $num = 5;

        $towers = [];

        while ($sheet->getCell('B' . $num)->getValue() != null) {
            $tower = [];
            
            $tower['no'] = $sheet->getCell('B' . $num)->getValue();
            $location = Location::where('name', $sheet->getCell('C' . $num)->getValue())->get();
            $tower['location_id'] = $location[0]->id;
            $tower['type'] = $sheet->getCell('D' . $num)->getValue();
            $tower['lat'] = $sheet->getCell('E' . $num)->getValue();
            $tower['long'] = $sheet->getCell('F' . $num)->getValue();
            $tower['user_id'] = auth()->user()->id;

            array_push($towers, $tower);

            $num++;
        }

        foreach($towers as $tower) {
            Tower::create($tower);
        }

        return redirect('/tool')->with('message', 'Import Data Tapak Tower Berhasil');
    }
    //

    // Ekspor dan Impor data Row

    public function exportRow(Request $request)
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

        $sheet->setCellValue('A1', 'REKAP DATA ROW');
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

        $rownum = 5;
        $num = 1;

        $rows = Row::all();

        foreach ($rows as $row) {
            $sheet->setCellValue('A' . $rownum, $num);
            $sheet->setCellValue('B' . $rownum, $row->firsttower->no . ' - ' . $row->secondtower->no);
            $sheet->setCellValue('C' . $rownum, $row->location->name);

            $currLand = null;

            if ($row->lands->isEmpty()) {
                $rownum++;
            }
            foreach ($row->lands as $land) {
                $prevLand = $land;

                if (!$currLand || $currLand->owner != $prevLand->owner) {
                    $sheet->setCellValue('D' . $rownum, $land->owner->name);
                }

                if (!$currLand || $currLand->type != $prevLand->type || $currLand->area != $prevLand->area) {
                    $sheet->setCellValue('E' . $rownum, $land->type);
                }
                $sheet->setCellValue('F' . $rownum, $land->area);

                if ($land->plants->isEmpty()) {
                    $rownum++;
                }
                foreach ($land->plants as $plant) {
                    $sheet->setCellValue('G' . $rownum, $plant->name);
                    $sheet->setCellValue('H' . $rownum, $plant->age);
                    $sheet->setCellValue('I' . $rownum, $plant->height);
                    $sheet->setCellValue('J' . $rownum, $plant->diameter);
                    $sheet->setCellValue('K' . $rownum, $plant->total);
                    $rownum++;
                    $currLand = $prevLand;
                }
                $currLand = $prevLand;
            }
            $num++;
        }

        $fileName = 'Rekap Data RoW.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
    }

    public function importRow(Request $request)
    {
        $spreadsheet = IOFactory::load($request->file);
        $sheet = $spreadsheet->getActiveSheet();

        $num = 5;

        $rows = [];

        while ($sheet->getCell('B' . $num)->getValue() != null) {
            $row = [];

            $towers = explode(' - ', $sheet->getCell('B' . $num)->getValue());
            $location = Location::where('name', $sheet->getCell('C' . $num)->getValue())->get();

            $firsttower = Tower::where('no', $towers[0])->where('location_id', $location[0]->id)->get();
            $secondtower = Tower::where('no', $towers[1])->where('location_id', $location[0]->id)->get();
            
            $row['tower1_id'] = $firsttower[0]->id;
            $row['tower2_id'] = $secondtower[0]->id;
            $row['location_id'] = $location[0]->id;
            $row['user_id'] = auth()->user()->id;

            array_push($rows, $row);

            $num++;
        }

        foreach($rows as $row) {
            Row::create($row);
        }

        return redirect('/tool')->with('message', 'Import Data RoW Berhasil');
    }
    //

    // Ekspor dan Impor data Lahan

    public function exportLahan(Request $request)
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

    public function importLahan(Request $request)
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
                'user_id' => $land['user_id']
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
                    ->with(['plants', 'owner'])
                    ->where('area', $land['area'])
                    ->where('land_owner_id', $land_input['land_owner_id'])
                    ->get();
                
                if ($tmpLand->isEmpty()) $landData = Land::create($land_input);
                else $landData = $tmpLand->first();
            }

            if ($land['plant']) {
                $plant_input = [
                    'name' => $land['plant'],
                    'age' => $land['age'],
                    'height' => $land['height'],
                    'diameter' => $land['diameter'],
                    'total' => $land['total']
                ];

                $landData->plants()->create($plant_input);
            }
        }

        return redirect('/tool')->with('message', 'Import Data Lahan Berhasil');
    }
}
