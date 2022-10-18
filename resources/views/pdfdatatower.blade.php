<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF LAHAN</title>

    <link rel="stylesheet" href="{{ public_path('/css/pdf.css') }}">
</head>

@foreach ($lands as $land)

    <body>
        <div class="container">
            <div class="row">
                <div class="col-1">
                    <img src="{{ public_path('/img/pln-logo.png') }}" alt="" height="50px"
                        style="margin: 25px 0 0 0;">
                </div>
                <div class="col-6" style="margin-left: -20px">
                    <p class="text text-bold" style="margin-top: 26px">PT. PLN (Persero)</p>
                    <p class="text text-bold">UNIT INDUK PEMBANGUNAN SUMATERA BAGIAN SELATAN</p>
                    <p class="text text-bold">UNIT PELAKSANA PROYEK SUMATERA BAGIAN SELATAN I</p>
                </div>
                <div class="col-4" style="float: right; margin-top: 33px">
                    <img src="{{ public_path('/img/logo_ptsi.png') }}" alt="" width="250px">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <center>
                        <h1 class="text-md">
                            DAFTAR INVENTARISASI TAPAK TOWER
                        </h1>
                        <h1 class="text-md">
                            JALUR
                            {{ strtoupper($land->tower->location->name) }}
                        </h1>
                    </center>
                </div>
            </div>

            <div class="row">
                <div class="col-5">
                    <p class="text">TANGGAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        {{ $land->updated_at->format('d-m-Y') }}</p>
                    <p class="text">NAMA PEMILIK &nbsp; : {{ $land->owner->name }}</p>
                    <p class="text">ALAMAT
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        : </p>
                </div>
                <div class="col-7">
                    <p class="text" id="desa">DESA / KELURAHAN &nbsp;&nbsp;&nbsp;: {{ $villages[$loop->index] }}
                    </p>
                    <p class="text" id="kecamatan">KECAMATAN
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        {{ $districts[$loop->index] }}</p>
                    <p class="text" id="kabupaten">KABUPATEN
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        {{ $regencies[$loop->index] }}</p>
                </div>
            </div>

            <div class="row">
                <table>
                    <thead>
                        <tr>
                            <td rowspan="2">NO</td>
                            <td rowspan="2">TOWER</td>
                            <td colspan="2">TANAH</td>
                            <td colspan="5">TANAM TUMBUH</td>
                            <td rowspan="2">KETERANGAN</td>
                        </tr>
                        <tr>
                            <td>Jenis Tanah</td>
                            <td>Luas (m<sup style="font-size: 8px;">2</sup>)</td>
                            <td>Nama Tanaman</td>
                            <td>Umur (th)</td>
                            <td>Tinggi (m)</td>
                            <td>Diameter (cm)</td>
                            <td>Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                            $currLand = null;
                        @endphp
                        @if ($land->plants->isEmpty())
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>
                                    {{ $land->tower->no }}
                                </td>
                                <td>{{ $land->type }}</td>
                                <td>{{ $land->area }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($land->plants as $plant)
                                @if ($loop->iteration <= 20)
                                    @php
                                        $prevLand = $land;
                                    @endphp
                                    <tr>
                                        <td>{{ $counter }}</td>

                                        @if ($prevLand != $currLand)
                                            <td>
                                                {{ $land->tower->no }}
                                            </td>
                                            <td>{{ $land->type }}</td>
                                            <td>{{ $land->area }}</td>
                                        @else
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td>{{ $plant->name }}</td>
                                        <td>{{ $plant->age }}</td>
                                        <td>{{ $plant->height }}</td>
                                        <td>{{ $plant->diameter }}</td>
                                        <td>{{ $plant->total }}</td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $currLand = $prevLand;
                                        $counter++;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        @for ($i = $counter; $i <= 21; $i++)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            
            <div class="row" style="margin-top: 10px">
                <div class="col-3 rect"></div>
                <div class="col-5">
                    <p class="text text-bold">TOWER TYPE
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        {{ $land->tower->type }}
                    </p>
                    <p class="text text-bold">
                        KOORDINAT&nbsp;&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        {{ $land->tower->lat }}
                    </p>
                    <p class="text text-bold">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Y&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        {{ $land->tower->long }}</p>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-5">
                    <center>
                        <h1 class="text text-bold">PETUGAS INVENTARISASI</h1>
                    </center>
                    <table id="petugas">
                        <thead>
                            <tr>
                                <td style="width: 10%;">NO</td>
                                <td style="width: 30%;">NAMA</td>
                                <td style="width: 25%;">INSTANSI</td>
                                <td>TANDA TANGAN</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if ($land->user->team)
                                @foreach ($land->user->team->members as $member)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>PT.SI</td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @endforeach

                                @for ($i = $count; $i <= 7; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @else
                                @for ($i = $count; $i <= 7; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-7">
                    <div class="row sign" style="margin-top: 20px">
                        <div class="col-6">
                            <center class="text" style="margin-bottom: 5px">KEPALA DESA / <br>LURAH</center>
                            <br>
                            <br>
                            <br>
                            <center class="text">(______________________)</center>
                        </div>
                        <div class="col-6" style="float: right">
                            <center class="text">PEMILIK LAHAN</center>
                            <br>
                            <br>
                            <br>
                            <br>
                            <center class="text">(______________________)</center>
                        </div>
                    </div>
                    <div class="row sign" style="margin-top: 20px;">
                        <div class="col-12">
                            <center class="text">MENGETAHUI, <br>CAMAT</center>
                            <br>
                            <br>
                            <br>
                            <center class="text">(______________________)</center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endforeach

</html>
