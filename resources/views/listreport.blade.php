@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">{{ $title }}</h2>
            {{-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Berikut adalah data
                lengkap laporan harian yang telah berhasil disi oleh petugas lapangan. Dari sini admin dapat mengubah , mengedit,
                menambah dan menghapus data yang sudah diinputkan</p> --}}
        </div>
        <!-- page card -->

        <div class="row">
            <!-- DataTales Example -->
            <div class="shadow mb-4">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-md-6">
                        <div class="container">
                            <form class="d-flex m-0" role="search">
                            <h6>cari :</h6>
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                            </form>
                        </div>
                        </div>
                        <div class="col-md-6 d-flex mb-3">
                        <label class="col-4 d-sm-none d-md-block d-none d-sm-block p-sm-0 h-100"> <h6 class="h6 font-weight-bold mt-lg-2">Filter berasarkan :</h6></label>
                        <select class="col-4 form-select form-control ml-n3" id="kategori">
                            <option selected>Kategori</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <select class="col-4 form-select form-control ml-3" id="penginput">
                            <option selected>Penginput</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        </div>
                    </div> -->
                    <div class="row mb-3 d-sm-flex">
                        {{-- <div class="col-md-4 col-sm-12">
                            <h6 class="mt-2 font-weight-bold">INV : {{ $towers[0]->location->inventory->name }}</h6>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <h6 class="mt-2 font-weight-bold">JALUR : {{ $towers[0]->location->name }}</h6>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <h6 class="mt-2 font-weight-bold">TAPAK : {{ $towers[0]->no }}</h6>
                        </div> --}}
                        <!-- <div class="col-md-6 d-flex">
                        <div class="col-md-3 d-sm-none d-md-block d-none d-sm-block"><h6 class="mt-2 font-weight-bold">cari :</h6></div>
                        <div class="col-md-6 col-sm-12"><input class="form-control" type="search" placeholder="Search" aria-label="Search" /></div>
                        </div>
                        <div class="col-md-6 col-sm-12 d-flex">
                        <label class="col-md-4 d-sm-none d-md-block d-none d-sm-block"> <h6 class="h6 font-weight-bold mt-lg-2">Filter berasarkan :</h6></label>
                        <select class="col-md-4 col-sm-12 form-select form-control ml-lg-n2" id="kategori">
                            <option selected>Kategori</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <select class="col-md-4 col-sm-12 form-select form-control ml-lg-2" id="penginput">
                            <option selected>Penginput</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        </div> -->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Ruas Jalur</th>
                                    {{-- <th>No Tower</th> --}}
                                    <th>Tanggal Input</th>
                                    <th>Penginput</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>{{ $report->location->name }}</td>
                                        {{-- <td>{{ $report->firsttower->no }} - {{ $report->secondtower->no }}</td> --}}
                                        <td>{{ $report->created_at->format('d M Y') }}</td>
                                        <td>{{ $report->team->name }}</td>
                                        <td>
                                            <a href="">Cetak</a> | <a href="">Lihat</a> | <a href="">Edit</a> | <a href="">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
<!-- modal start -->
            {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input Data Daily Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="">
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
                            <input type="date" class="form-control col-7" name="tanggal" />
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <select class="col-7 form-select form-control" id="kordinator">
                              <option value="" disabled selected>Cuaca</option>
                              <option value="1">Cerah</option>
                              <option value="2">Hujan</option>
                            </select>
                          </div>
                          <h6 class="h6 font-weight-bold">Fasilitas Pekerjaan</h6>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="kordinator" class="col-md-4">Kordinator</label>
                            <select class="col-md-3 form-select form-control" id="kordinator">
                              <option selected>Hadir</option>
                              <option value="1">Tidak Hadir</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="surveyor1" class="col-md-4">Sorveyor 1</label>
                            <select class="col-md-3 form-select form-control" id="surveyor1">
                              <option selected>Hadir</option>
                              <option value="1">Tidak Hadir</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="sorveyor2" class="col-md-4">Sorveyor 2</label>
                            <select class="col-md-3 form-select form-control" id="sorveyor2">
                              <option selected>Hadir</option>
                              <option value="1">Tidak Hadir</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="admin1" class="col-md-4">Admin 1</label>
                            <select class="col-md-3 form-select form-control" id="admin1">
                              <option selected>Hadir</option>
                              <option value="1">Tidak Hadir</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="admin2" class="col-md-4">Admin 2</label>
                            <select class="col-md-3 form-select form-control" id="admin2">
                              <option selected>Hadir</option>
                              <option value="1">Tidak Hadir</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="driver" class="col-md-4">Driver</label>
                            <select class="col-md-3 form-select form-control" id="driver">
                              <option selected>Hadir</option>
                              <option value="1">Tidak Hadir</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 mx-auto">
                          <h6 class="h6 font-weight-bold">Fasilitas Pekerjaan</h6>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="gps" class="col-md-4">GPS Geodetic</label>
                            <select class="col-md-3 form-select form-control" id="gps">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="laptop" class="col-md-4">Laptop</label>
                            <select class="col-md-3 form-select form-control" id="laptop">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="printer" class="col-md-4">Printer</label>
                            <select class="col-md-3 form-select form-control" id="printer">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="kamera" class="col-md-4">Kamera Digital</label>
                            <select class="col-md-3 form-select form-control" id="kamera">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="scanner" class="col-md-4">Scanner</label>
                            <select class="col-md-3 form-select form-control" id="scanner">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="mobil" class="col-md-4">Mobil</label>
                            <select class="col-md-3 form-select form-control" id="mobil">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="motor" class="col-md-4">Motor</label>
                            <select class="col-md-3 form-select form-control" id="motor">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="apd" class="col-md-4">APD</label>
                            <select class="col-md-3 form-select form-control" id="apd">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <h6 class="h6 font-weight-bold">Material Pekerjaan</h6>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="atk" class="col-md-4">ATK</label>
                            <select class="col-md-3 form-select form-control" id="atk">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="cat" class="col-md-4">Cat Pilox</label>
                            <select class="col-md-3 form-select form-control" id="cat">
                              <option selected>Ada</option>
                              <option value="1">Tidak Ada</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12 mx-auto">
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="waktum" class="col-md-2">Waktu Mulai</label>
                            <input type="time" class="col-md-2" form-control" id="waktum" />
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="waktus" class="col-md-2">Waktu Selesai</label>
                            <input type="time" class="col-md-2" form-control" id="waktus" />
                          </div>
                          <div class="row d-flex form-group mb-4 col-sm-12">
                            <label for="kegiatan" class="col-md-2">Kegiatan</label>
                            <input type="text" class="col-md-10" form-control" id="kegiatan" placeholder="Text Area" />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit Data</button>
                  </div>
                </div>
              </div>
            </div> --}}
            <!-- modal end -->