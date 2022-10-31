@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Laporan</h2>
            <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silakan pantau
                perkembangan atau input data monitoring SI melalui laporan ini. Melalui halaman anda dapat melihat laporan
                acara umum, mengambil aksi cepat untuk melakukan input data atau melakukan tindakan lainnya.</p>
        </div>

        <!-- page data filter -->
        <div class="row px-lg-4 mb-5">
            <div class="col-xl-8 col-lg-8">
                <div class="row">
                    <h4 class="col-md-3 px-0">Pemutakhiran Data :</h4>
                    <div class="col-md-2 dropdown p-0">
                        <select class="form-select bg-yellow btn-sm border-0" id="wilayah">
                            @if ($inventories->count() > 1)
                                <option selected value="all">Semua Wilayah</option>
                            @endif
                            @foreach ($inventories as $inventory)
                                <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- page card -->
        <div class="row">
            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card-laporan bg-blue-sapphire m-auto h-100">
                    <div class="card-body d-flex flex-column justify-content-evenly px-4 py-3 h-100">
                        <span>
                            <h5>Progres RoW</h5>
                        </span>
                        <span class="d-flex">
                            <h1 id="row-data">{{ $row }}</h1>
                            <h6>%</h6>
                        </span>
                        <span>
                            <p>Data RoW Terisi</p>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card-laporan bg-blue-charcoal m-auto h-100">
                    <div class="card-body d-flex flex-column justify-content-evenly px-4 py-3 h-100">
                        <span>
                            <h5>Progres Tapak Tower</h5>
                        </span>
                        <span class="d-flex">
                            <h1 id="tower-data">{{ $tower }}</h1>
                            <h6>%</h6>
                        </span>
                        <span>
                            <p>Data Tapak Tower Terisi</p>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="card-laporan bg-blue m-auto h-100">
                    <div class="card-body d-flex flex-column justify-content-evenly px-4 py-3 h-50">
                        <span>
                            <h5>Daily Report</h5>
                        </span>
                        <span class="d-flex">
                            {{-- <h1>50</h1> --}}
                            <a href="/dailyreport">
                                <h6>>> LIHAT DI SINI << </h6>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- page grafik -->
        <div class="row">
            <div class="col-12 mt-3">
                <h5 class="h5 mb-3 font-weight-bold">Progress Per Wilayah</h5>
            </div>
            <div class="col-xl-12">
                <div class="bg-white shadow">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="h6 mb-3 font-weight-bold">Progress Data RoW</h6>
                                <canvas id="row-wilayah-chart" style="width:100%;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h6 class="h6 mb-3 font-weight-bold">Progress Data Tapak Tower</h6>
                                <canvas id="tower-wilayah-chart" style="width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3">
                <h5 class="h5 mb-3 font-weight-bold">Progress Per Jalur</h5>
            </div>
            <div class="col-xl-12">
                <div class="bg-white shadow">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="h6 mb-3 font-weight-bold">Progress Data RoW</h6>
                                <canvas id="row-jalur-chart" style="width:100%;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h6 class="h6 mb-3 font-weight-bold">Progress Data Tapak Tower</h6>
                                <canvas id="tower-jalur-chart" style="width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3">
                <h5 class="h5 mb-3 font-weight-bold">Progress Per Tim</h5>
            </div>
            <div class="col-xl-12">
                <div class="bg-white shadow">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="h6 mb-3 font-weight-bold">Progress Data RoW</h6>
                                <canvas id="row-tim-chart" style="width:100%;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h6 class="h6 mb-3 font-weight-bold">Progress Data Tapak Tower</h6>
                                <canvas id="tower-tim-chart" style="width:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
