@extends('layouts.main')

@section('content')
     <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
              <h2 class="h2 mb-3 font-weight-bold">Data Lahan</h2>

              <div class="row d-flex flex-column flex-lg-row justify-content-between">
                <div class="d-flex flex-row col-md-8 col-sm-12">
                  <div class="col-md-3 col-sm-12">
                    <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"><i class="fas fa-plus mr-2"></i>Tambah</button>
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-bs-whatever="@getbootstrap"><i class="fas fa-download mr-2"></i>Import</button>
                  </div>
                  <div class="col-md-3 col-sm-12">
                    <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="@getbootstrap"><i class="fas fa-upload mr-2"></i>Export</button>
                  </div>
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
                          <th>Pemilik</th>
                          <th>Jenis Lahan</th>
                          <th>Luas</th>
                          <th>Tim</th>
                          <th>Tindakan</th>
                          <th>Tanaman</th>
                          <th>Lampiran</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Jarwo</td>
                          <td>Perkebunan</td>
                          <td>245m2</td>
                          <td>Tim A</td>
                          <td><a href="">Cetak</a>| <a href="">Lihat</a>| <a href="">Edit</a>| <a href="">Hapus</a></td>
                          <td>
                            <button class="btn-sm btn-outline-primary font-weight-bold bg-yellow" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"><i class="fas fa-plus mr-2"></i>Tambah</button>
                          </td>
                          <td>
                            <a href="" class="btn-primary"><i class="fas fa-file fa-sm fa-fw mr-2"></i>Browse File</a>
                          </td>
                        </tr>
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
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input Data ROW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                        <select class="form-select form-control" id="wilayah">
                          <option selected>INV SUMSEL 1</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Pilih jalur SUTT</h6>
                        <select class="form-select form-control" id="jalur">
                          <option selected>Jalur SUTT kV Soralangun - Muara Rupit</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="row d-flex flex-row">
                        <div class="col-md-6 form-group mb-4">
                          <h6 class="font-weight-light mt-n2">Pilih Tipe Input</h6>
                          <select class="form-select form-control" id="tapak">
                            <option selected>ROW</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                        </div>
                        <div class="col-md-6 form-group mb-4">
                          <h6 class="font-weight-light mt-n2">Pilih ROW</h6>
                          <select class="form-select form-control" id="tapak">
                            <option selected>T.002</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal3" data-bs-whatever="@getbootstrap">Submit Data</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal end -->
            <!-- modal start 2 -->
            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header d-flex flex-column">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h6>INV : Sumsel 1</h6>
                    <h6>Jalur : Sumsel 1</h6>
                    <h6>ROW : T.71 - T.72</h6>
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel3">Form Lahan</h5>
                  </div>
                  <div class="modal-body">
                    <form>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Nama</h6>
                        <input type="text" class="form-control" name="name" placeholder="Nama Pemilik" />
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Alamat</h6>
                        <input type="text" class="form-control" name="name" placeholder="Alamat" />
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Desa</h6>
                        <input type="text" class="form-control" name="name" placeholder="Desa / Kelurahan" />
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Kecamatan</h6>
                        <input type="text" class="form-control" name="name" placeholder="Kecamatan" />
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Kabupaten</h6>
                        <input type="text" class="form-control" name="name" placeholder="Kabupaten" />
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Jenis Tanah</h6>
                        <input type="text" class="form-control" name="name" placeholder="Jenis Tanah" />
                      </div>
                      <div class="form-group mb-4">
                        <h6 class="font-weight-light mt-n2">Luas Tanah</h6>
                        <input type="text" class="form-control" name="name" placeholder="Luas Tanah" />
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal">Submit Data</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal end 2 -->
          </div>
@endsection