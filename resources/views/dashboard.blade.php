@extends('layouts.main')
    @section('content')
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
              <h2 class="h2 mb-3 font-weight-bold">Selamat Datang di Aplikasi Monitoring SI</h2>
              <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silahkan pantau perkembangan atau input data monitoring SI melalui dashboard ini. Melalui halaman anda dapat melihat laporan acara umum, mengambil aksi cepat untuk melakukan input data atau melakukan tindakan lainnya.</p>
            </div>
            <!-- page card -->
            <div class="row">
              <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card py-2 m-auto">
                  <div class="card-body d-flex flex-column px-4">
                    <h4 class="text-center font-weight-bold">Input Inventarisasi Data Lahan</h4>
                    <img src="img/lahan.png" alt="" width="200px" class="mx-auto my-4" />
                    <p class="font-weight-light text-center">Silahkan melakukan input inventaris lahan melalui tombol dibawah ini :</p>
                    <a href="" class="btn btn-primary btn-user btn-block m-auto w-auto">Mulai input</a>
                  </div>
                </div>
              </div>

              <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card py-2 m-auto">
                  <div class="card-body d-flex flex-column px-4">
                    <h4 class="text-center font-weight-bold">Input Inventarisasi Ruang Bebas</h4>
                    <img src="img/ruangbebas.png" alt="" width="200px" class="mx-auto my-4" />
                    <p class="font-weight-light text-center">Silahkan melakukan input inventaris lahan melalui tombol dibawah ini :</p>
                    <a href="" class="btn btn-primary btn-user btn-block m-auto w-auto">Mulai input</a>
                  </div>
                </div>
              </div>

              <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card py-2 m-auto">
                  <div class="card-body d-flex flex-column px-4">
                    <h4 class="text-center font-weight-bold">Laporan Umum</h4>
                    <img src="img/report.png" alt="" width="200px" class="mx-auto my-4" />
                    <p class="font-weight-light text-center">Silahkan melakukan input inventaris lahan melalui tombol dibawah ini :</p>
                    <a href="" class="btn btn-primary btn-user btn-block m-auto w-auto">Mulai input</a>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card py-2 m-auto">
                  <div class="card-body d-flex flex-column px-4">
                    <h4 class="text-center font-weight-bold">List Data</h4>
                    <img src="img/listdata.png" alt="" width="200px" class="mx-auto my-4" />
                    <p class="font-weight-light text-center">Silahkan melakukan input inventaris lahan melalui tombol dibawah ini :</p>
                    <a href="" class="btn btn-primary btn-user btn-block m-auto w-auto">Mulai input</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
    @endsection