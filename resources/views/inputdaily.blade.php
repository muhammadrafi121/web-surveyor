@extends('layouts.main')

    @section('content')
            <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
                    <h2 class="h2 mb-3 font-weight-bold">Form Input Data Daily Report</h2>
                    <!-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silahkan isi form berikut ini untuk menambahkan data tapak tower</p> -->
                    </div>
                    <!-- page form akun -->
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

                        <button type="submit" class="btn btn-primary">Submit Data</button>
                        </div>
                    </div>
                    </form>
                </div>
    @endsection