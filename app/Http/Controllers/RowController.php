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
            $sheet->setCellValue('B' . $rownum, $row->firsttower->no . " - " . $row->secondtower->no);
            $sheet->setCellValue('C' . $rownum, $row->location->name);

            $currLand = null;

            if ($row->lands->isEmpty()) $rownum++;
            foreach ($row->lands as $land) {
                $prevLand = $land;

                if (!$currLand || $currLand->owner != $prevLand->owner) {
                    $sheet->setCellValue('D' . $rownum, $land->owner->name);
                }

                if (!$currLand || $currLand->type != $prevLand->type || $currLand->area != $prevLand->area) {
                    $sheet->setCellValue('E' . $rownum, $land->type);
                }
                $sheet->setCellValue('F' . $rownum, $land->area);

                if ($land->plants->isEmpty()) $rownum++;
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
}
