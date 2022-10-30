<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF DAILY REPORT</title>

    <style>
        * {
            /* border: 1px red solid; */
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            background: rgb(255, 255, 255);
        }

        .container {
            margin: 10px;
            /* padding-left: 15px;
            padding-right: 15px; */
        }

        .row {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-gap: 20px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .col-1,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-10,
        .col-11,
        .col-12 {
            float: left;
            margin: 2px;
        }

        .col-1 {
            width: 8.3333%;
        }

        .col-2 {
            width: 16.6667%;
        }

        .col-3 {
            width: 25%;
        }

        .col-4 {
            width: 33.3333%;
        }

        .col-5 {
            width: 41.6667%;
        }

        .col-6 {
            width: 50%;
        }

        .col-7 {
            width: 58.3333%;
        }

        .col-8 {
            width: 66.6667%;
        }

        .col-9 {
            width: 75%;
        }

        .col-10 {
            width: 83.3333%;
        }

        .col-11 {
            width: 91.6667%;
        }

        .col-12 {
            width: 100%;
        }

        .text-bold {
            font-weight: bold;
        }

        .text {
            font-size: 12px;
        }

        .text-md {
            font-size: 14px;
        }

        table {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            font-weight: bold;
            text-align: center;
        }

        table td {
            border: 1px solid black;
        }

        table tbody td {
            height: 20px;
            text-align: center;
        }

        #petugas tbody td {
            padding: 5px;
        }

        .sign {
            height: 110px;
        }

        .rect {
            margin-left: 20px;
            margin-right: 20px;
            height: 100px;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 20px">
        <div class="row">
            <div class="col-12">
                <table style="">
                    <thead>
                        <tr>
                            <td colspan="5" style="height: 60px;">
                                <div class="row" style="position: relative;">
                                    <div class="col-8" style="margin-left: 0; margin-top: -25px">
                                        <img src="data:image;base64, {{ $ptsi }}" alt="" width="300px">
                                    </div>
                                    <div class="col-3" style="margin-left: 290px; margin-top: -25px">
                                        <img src="data:image;base64, {{ $pln }}" alt="" width="40px">
                                    </div>
                                </div>
                            </td>
                            <td colspan="3" style="padding-top: 10px; padding-bottom: 10px">
                                <h1>LAPORAN HARIAN</h1>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="5"
                                style="text-align: left; padding-left: 5px; padding-top: 5px; border-top: 0; vertical-align: top; border-right: 0; border-bottom: 0;">
                                <h3>PROYEK</h3>
                            </td>
                            <td colspan="3" rowspan="5"
                                style="text-align: left; padding-left: 5px; padding-top: 5px; border-top: 0; vertical-align: top; font-weight: light; border-left: 0; border-bottom: 0;">
                                <p>JASA INVENTARISASI DAN IDENTIFIKASI TANAH, BANGUNAN DAN TANAMAN SERTA PENDAMPINGAN
                                    KEGIATAN (PERTEMUAN) YANG TERKAIT PROSES PENGADAAN TANAH</p>
                                <p>DAN PENYEDIAAN RUANG BEBAS (RIGHT OF WAY) PADA PEMBANGUNAN SALURAN UDARA TEGANGAN
                                    TINGGI / EKSTRA TINGGI (SUTT/SUTET) DAN GARDU INDUK DI WILAYAH KERJA PT PLN
                                    (PERSERO) UNIT PELAKSANA PROYEK SUMATERA BAGIAN SELATAN {{ $no_inv }}</p>
                            </td>
                            <td colspan="3"
                                style="text-align: left; padding-left: 5px; padding-top: 5px; border-bottom: 0">
                                <h3>LOKASI</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                style="border-top: 0; border-bottom: 0; padding-bottom: 10px; text-align: left; padding-left: 5px">
                                <h3>{{ $report->location->name }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                style="text-align: left; padding-left: 5px; padding-top: 5px; border-top: 0; border-bottom: 0; padding-bottom: 10px;">
                                <h3>{{ strtoupper($report->team->name) }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                style="text-align: left; padding-left: 5px; padding-top: 5px; border-top: 0; border-bottom: 0; padding-bottom: 10px;">
                                <h3>TANGGAL : {{ date('d-m-Y', strtotime($report->date)) }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h3>CUACA</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"
                                style="border-top: 0; border-right: 0; border-bottom: 0; padding-left: 5px; text-align: left;">
                                <h3>Klien</h3>
                            </td>
                            <td colspan="3"
                                style="border-top: 0; border-left: 0; border-bottom: 0; padding-left: 5px; text-align: left; font-weight: light;">
                                <p>PT. PLN (Persero) UPP SUMBAGSEL {{ $no_inv }}</p>
                            </td>
                            <td style="text-align: left; padding-left: 5px;">
                                <h4>Cerah</h4>
                            </td>
                            <td colspan="2">
                                @if ($report->weather == 'Cerah')
                                    v
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"
                                style="border-top: 0; border-right: 0; border-bottom: 0; padding-left: 5px; text-align: left;">
                                <h3>No. KONTRAK</h3>
                            </td>
                            <td colspan="3"
                                style="border-top: 0; border-left: 0; border-bottom: 0; padding-left: 5px; text-align: left; font-weight: light;">
                            </td>
                            <td style="text-align: left; padding-left: 5px;">
                                <h4>Mendung</h4>
                            </td>
                            <td colspan="2">
                                @if ($report->weather == 'Mendung')
                                    v
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"
                                style="border-top: 0; border-right: 0; border-bottom: 0; padding-left: 5px; text-align: left;">
                                <h3>No. IK</h3>
                            </td>
                            <td colspan="3"
                                style="border-top: 0; border-left: 0; border-bottom: 0; padding-left: 5px; text-align: left; font-weight: light;">
                            </td>
                            <td style="text-align: left; padding-left: 5px;">
                                <h4>Hujan</h4>
                            </td>
                            <td colspan="2">
                                @if ($report->weather == 'Hujan')
                                    v
                                @endif
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" style="text-align: left; padding: 5px">
                                <h3>TENAGA KERJA</h3>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 3%">
                                <h3>No</h3>
                            </td>
                            <td colspan="4" style="text-align: left; padding-left: 5px;">
                                <h3>Jabatan</h3>
                            </td>
                            <td style="width: 12%;">
                                <h3>Jumlah</h3>
                            </td>
                            <td style="width: 12%;">
                                <h3>Hadir</h3>
                            </td>
                            <td style="width: 12%;">
                                <h3>Tidak Hadir</h3>
                            </td>
                        </tr>
                        @foreach ($report->manPowers as $manPower)
                            <tr>
                                <td>
                                    {{ chr(96 + $loop->iteration) }}
                                </td>
                                <td colspan="4" style="text-align: left; padding-left: 5px">
                                    {{ $manPower->name }}
                                </td>
                                <td>
                                    {{ $manPower->total }}
                                </td>
                                <td>
                                    @if ($manPower->status == 1)
                                        v
                                    @endif
                                </td>
                                <td>
                                    @if ($manPower->status == 0)
                                        v
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="8" style="text-align: left; padding: 5px;">
                                <h3>FASILITAS DAN MATERIAL</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>No</h3>
                            </td>
                            <td colspan="4" style="text-align: left; padding-left: 5px;">
                                <h3>Fasilitas dan Material Pekerjaan</h3>
                            </td>
                            <td>
                                <h3>Jumlah</h3>
                            </td>
                            <td>
                                <h3>Ada</h3>
                            </td>
                            <td>
                                <h3>Tidak Ada</h3>
                            </td>
                        </tr>
                        @foreach ($report->facilities as $facility)
                            <tr>
                                <td>
                                    {{ chr(96 + $loop->iteration) }}
                                </td>
                                <td colspan="4" style="text-align: left; padding-left: 5px">
                                    {{ $facility->name }}
                                </td>
                                <td>
                                    {{ $facility->total }}
                                </td>
                                <td>
                                    @if ($facility->status == 1)
                                        v
                                    @endif
                                </td>
                                <td>
                                    @if ($facility->status == 0)
                                        v
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="8" style="text-align: left; padding: 5px;">
                                <h3>URAIAN PEKERJAAN</h3>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2">
                                <h3>No</h3>
                            </td>
                            <td colspan="2">
                                <h3>Waktu Pelaksanaan</h3>
                            </td>
                            <td colspan="5" rowspan="2">
                                <h3>Kegiatan</h3>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 12%;">Mulai</td>
                            <td style="width: 12%;">Selesai</td>
                        </tr>
                        @foreach ($report->activities as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loop->iteration == 1 ? $report->time_start : '' }}</td>
                                <td>{{ $loop->iteration == 1 ? $report->time_end : '' }}</td>
                                <td colspan="5" style="text-align: left; padding-left: 5px">
                                    <p>{{ $activity->activity }}</p>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" style="border-bottom: 0">Dibuat Oleh</td>
                            <td colspan="4" style="border-bottom: 0">Mengetahui</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-top: 0">
                                <h3>PT. SURVEYOR INDONESIA</h3>
                            </td>
                            <td colspan="4" style="border-top: 0">
                                <h3>PT. PLN (Persero) UPP SUMBAGSEL {{ $no_inv }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="height: 30px; padding-top: 100px; width: 50%;">
                                ________________________
                                <br>
                                Koordinator Tim
                            </td>
                            <td colspan="4" style="height: 30px; padding-top: 100px;">
                                ________________________
                                <br>
                                Ketua Tim
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

@if (!$report->images->isEmpty())

    <body>
        <div class="container" style="margin-top: 20px">
            <div class="row">
                <div class="col-12">
                    <table style="">
                        <thead>
                            <tr>
                                <td style="height: 60px;">
                                    <div class="row" style="position: relative;">
                                        <div class="col-8" style="margin-left: 0; margin-top: -25px">
                                            <img src="data:image;base64, {{ $ptsi }}" alt=""
                                                width="300px">
                                        </div>
                                        <div class="col-3" style="margin-left: 290px; margin-top: -25px">
                                            <img src="data:image;base64, {{ $pln }}" alt=""
                                                width="40px">
                                        </div>
                                    </div>
                                </td>
                                <td style="padding-top: 10px; padding-bottom: 10px">
                                    <h1>LAMPIRAN</h1>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="height: 450px">
                                    @if ($img1)
                                        <img src="data:image;base64, {{ $img1 }}" alt=""
                                            width="90%">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 450px">
                                    @if ($img2)
                                        <img src="data:image;base64, {{ $img2 }}" alt=""
                                            width="90%">
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
@endif

</html>
