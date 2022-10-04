@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div id="none" onclick="myFunction()"
                style="position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); ">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <img src="img/alert.png" alt="" srcset="" class="m-auto w-50" />
                            <h2 class="mx-auto mt-4 font-weight-bold">{{ session('message') }}</h2>
                            <div class="col-md-5 col-sm-12 d-flex justify-content-evenly mx-auto my-3">
                                <a href="http://" class="btn btn-primary mx-auto">Lihat Data</a>
                                <a href="http://" class="btn btn-primary bg-blue mx-auto">Cetak</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function myFunction() {
                    document.getElementById("none").style.display = "none";
                }
            </script>
        @endif
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Data Daily Report</h2>

            <div class="row d-flex flex-row justify-content-between">
                <div class="col-md-2 col-sm-12">
                    <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"><i
                            class="fas fa-plus mr-2"></i>Tambah</button>
                </div>
                <div class="col-md-4 col-sm-12 d-flex flex-column flex-lg-row mt-3 mt-md-0 mt-lg-0 mt-xl-0">
                    <p class="my-auto">Filter Berdasarkan :</p>
                    <select class="col-md-6 col-sm-12 form-select form-control ml-lg-2 my-auto" id="penginput">
                        <option selected>Semua Jalur</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- page card -->

        <div class="row">
            <!-- DataTales Example -->
            <div class="shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tim</th>
                                    <th>Penginput</th>
                                    <th>Waktu</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>{{ $report->date }}</td>
                                        <td>{{ $report->team->name }}</td>
                                        <td>{{ $report->user->name }}</td>
                                        <td>{{ $report->updated_at }}</td>
                                        <td class="text-center"><a href="">Cetak</a>| <a href="javascript:void(0)"
                                                data-bs-toggle="modal" data-bs-target="#report-modal-{{ $report->id }}"
                                                data-bs-whatever="@getbootstrap">Lihat</a>| <a href="">Edit</a>| <a
                                                href="">Hapus</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal start -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input Data Lahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/land" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                                <select class="form-select form-control" id="wilayah" name="wilayah">
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Pilih jalur SUTT</h6>
                                <select class="form-select form-control" id="jalur" name="jalur">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Pilih Tim</h6>
                                <select class="form-select form-control" id="tim" name="tim">
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }} /
                                            {{ $team->inventory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal3" data-bs-whatever="@getbootstrap" onclick="saveData()">Submit
                            Data</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
        <!-- modal start 2 -->
        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <form class="modal-content" action="/dailyreport" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input Data Daily Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @method('POST')
                        @csrf
                        <input type="hidden" id="jalur-id" name="jalur">
                        <input type="hidden" id="tim-id" name="tim_id">
                        <div class="row bg-white d-flex shadow-lg py-5 pl-md-3">
                            <div class="row d-sm-flex">
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <h6 class="font-weight-bold">INV :</h6>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <h6 class="font-weight-bold">JALUR :</h6>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <h6 class="font-weight-bold">TIM :</h6>
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <div class="row form-group mb-4 col-sm-12">
                                    <input type="date" class="form-control col-7" id="tanggal" name="tanggal" />
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <select class="col-7 form-select form-control" id="cuaca" name="cuaca">
                                        <option value="" disabled selected>Cuaca</option>
                                        <option value="Cerah">Cerah</option>
                                        <option value="Hujan">Hujan</option>
                                    </select>
                                </div>
                                <h6 class="h6 font-weight-bold">Fasilitas Pekerjaan</h6>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="kordinator" class="col-md-4">Koordinator</label>
                                    <label class="switch">
                                        <input type="checkbox" id="koordinator" name="koordinator">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="surveyor1" class="col-md-4">Sorveyor 1</label>
                                    <label class="switch">
                                        <input type="checkbox" id="surveyor1" name="surveyor1">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="sorveyor2" class="col-md-4">Sorveyor 2</label>
                                    <label class="switch">
                                        <input type="checkbox" id="surveyor2" name="surveyor2">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="admin1" class="col-md-4">Admin 1</label>
                                    <label class="switch">
                                        <input type="checkbox" id="admin1" name="admin1">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="admin2" class="col-md-4">Admin 2</label>
                                    <label class="switch">
                                        <input type="checkbox" id="admin2" name="admin2">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="driver" class="col-md-4">Driver</label>
                                    <label class="switch">
                                        <input type="checkbox" id="driver" name="driver">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <h6 class="h6 font-weight-bold">Fasilitas Pekerjaan</h6>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="gps" class="col-md-4">GPS Geodetic</label>
                                    <label class="switch">
                                        <input type="checkbox" id="gps" name="gps">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="laptop" class="col-md-4">Laptop</label>
                                    <label class="switch">
                                        <input type="checkbox" id="laptop" name="laptop">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="printer" class="col-md-4">Printer</label>
                                    <label class="switch">
                                        <input type="checkbox" id="printer" name="printer">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="kamera" class="col-md-4">Kamera Digital</label>
                                    <label class="switch">
                                        <input type="checkbox" id="kamera" name="kamera">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="scanner" class="col-md-4">Scanner</label>
                                    <label class="switch">
                                        <input type="checkbox" id="scanner" name="scanner">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="mobil" class="col-md-4">Mobil</label>
                                    <label class="switch">
                                        <input type="checkbox" id="mobil" name="mobil">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="motor" class="col-md-4">Motor</label>
                                    <label class="switch">
                                        <input type="checkbox" id="motor" name="motor">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="apd" class="col-md-4">APD</label>
                                    <label class="switch">
                                        <input type="checkbox" id="apd" name="apd">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <h6 class="h6 font-weight-bold">Material Pekerjaan</h6>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="atk" class="col-md-4">ATK</label>
                                    <label class="switch">
                                        <input type="checkbox" id="atk" name="atk">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="cat" class="col-md-4">Cat Pilox</label>
                                    <label class="switch">
                                        <input type="checkbox" id="cat" name="cat">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto">
                                <div class="row d-flex form-group mb-5 col-sm-12">
                                    <label for="waktum" class="col-md-3">Waktu Mulai</label>
                                    <input type="time" class="col-md-2 form-control" id="waktum" name="waktum" />
                                </div>
                                <div class="row d-flex form-group mb-5 col-sm-12">
                                    <label for="waktus" class="col-md-3">Waktu Selesai</label>
                                    <input type="time" class="col-md-2 form-control" id="waktus" name="waktus" />
                                </div>
                                <div class="row d-flex form-group mb-4 col-sm-12">
                                    <label for="kegiatan" class="col-md-2">Kegiatan</label>
                                    <input type="text" class="col-md-10 form-control" id="kegiatan" name="kegiatan"
                                        placeholder="Text Area" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-target="#exampleModalToggle3"
                            data-bs-toggle="modal">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- modal end -->
        <!-- modal start 3 -->
        @foreach ($reports as $report)
            <div class="modal fade" id="report-modal-{{ $report->id }}" tabindex="-1" aria-labelledby="report-modal-label-{{ $report->id }}"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input Data Daily Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row bg-white d-flex shadow-lg py-5 pl-md-3">
                                <div class="row d-sm-flex">
                                    <div class="col-md-5 col-sm-12 mb-2">
                                        <h6 class="font-weight-bold">INV &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $report->team->inventory->name }}</h6>
                                    </div>
                                    <div class="col-md-7 col-sm-12 mb-2">
                                        <h6 class="font-weight-bold">JALUR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $report->location->name }}</h6>
                                    </div>
                                </div>
                                <div class="row d-sm-flex">
                                    <div class="col-md-5 col-sm-12 mb-2">
                                        <h6 class="font-weight-bold">TIM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $report->team->name }}</h6>
                                    </div>
                                    <div class="col-md-5 col-sm-12 mb-2">
                                        <h6 class="font-weight-bold">TANGGAL : {{ $report->date }}</h6>
                                    </div>
                                </div>
                                <div class="row d-sm-flex">
                                    <div class="col-md-5 col-sm-12 mb-2">
                                        <h6 class="font-weight-bold">CUACA : {{ $report->weather }}</h6>
                                    </div>
                                </div>
                                <div class="row d-sm-flex">
                                    <table class="table table-bordered table-striped" id="dataTable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr>
                                                <td colspan="3">TENAGA KERJA</td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td>Jumlah</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report->manpowers as $manpower)
                                                <tr>
                                                    <td>{{ $manpower->name }}</td>
                                                    <td>{{ $manpower->total }}</td>
                                                    <td>{{ $manpower->status == 1 ? 'Hadir' : 'Tidak Hadir' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <td colspan="3">FASILITAS DAN MATERIAL</td>
                                            </tr>
                                            <tr>
                                                <td>Fasilitas dan Material Pekerjaan</td>
                                                <td>Jumlah</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report->facilities as $facility)
                                                <tr>
                                                    <td>{{ $facility->name }}</td>
                                                    <td>{{ $facility->total }}</td>
                                                    <td>{{ $facility->status == 1 ? 'Ada' : 'Tidak Ada' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <td colspan="3">URAIAN KEGIATAN</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Waktu Pelaksanaan</td>
                                                <td rowspan="2">Kegiatan</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 20%">Mulai</td>
                                                <td style="width: 20%">Selesai</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report->activities as $activity)
                                                <tr>
                                                    <td>{{ $report->time_start }}</td>
                                                    <td>{{ $report->time_end }}</td>
                                                    <td>{{ $activity->activity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-target="#report-modal-{{ $report->id }}"
                                data-bs-toggle="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- modal end -->
    </div>
@endsection
