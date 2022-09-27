@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Selamat Datang di Aplikasi Monitoring SI</h2>
            <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silakan pantau perkembangan atau input data monitoring SI melalui dashboard ini. Melalui halaman anda dapat melihat laporan acara umum, mengambil aksi cepat untuk melakukan input data atau melakukan tindakan lainnya.</p>
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
                            <h1>{{ $row }}</h1>
                            {{-- <h6>/500 tapak</h6> --}}
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
                            <h1>{{ $tower }}</h1>
                            {{-- <h6>/500 tapak</h6> --}}
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
                            <a href="/dailyreport"><h6>>> LIHAT DI SINI <<</h6></a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
