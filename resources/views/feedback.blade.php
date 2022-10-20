@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Bantuan</h2>
            <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Melalui halaman ini Anda
                dapat menghubungi admin dan memulai forum.</p>
        </div>

        <!-- page card -->
        <div class="row">
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card py-2 m-auto">
                    <div class="card-body d-flex flex-column px-4">
                        <h4 class="text-center font-weight-bold">Kontak Admin</h4>
                        <img src="/img/ruangbebas.png" alt="" width="300px" class="mx-auto my-4" />
                        <div class="row my-1">
                            <button onclick="admcontact()"
                                class="btn btn-primary btn-user btn-block m-auto w-auto">Hubungi</button>
                        </div>
                        <div class="row my-1">
                            <a href="/feedback/admin" class="btn btn-warning btn-user btn-block m-auto w-auto">Lihat Pesan Admin</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card py-2 m-auto">
                    <div class="card-body d-flex flex-column px-4">
                        <h4 class="text-center font-weight-bold">Feedback Forum</h4>
                        <img src="/img/report.png" alt="" width="300px" class="mx-auto my-4" />
                        <div class="row my-1">
                            <button onclick="feedback()"
                                class="btn btn-primary btn-user btn-block m-auto w-auto">Sampaikan</button>
                        </div>
                        <div class="row my-1">
                            <a href="/feedback/forum" class="btn btn-warning btn-user btn-block m-auto w-auto">Lihat Forum</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal start -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="/feedback" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Isi Form Berikut untuk Mengontak Admin
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="target" id="target">
                    <div class="form-group mb-4">
                        <label class="h5 font-weight-bold" for="title" id="subject-title">Subjek Kasus</label>
                        <h6 class="font-weight-light mt-n2" id="subject-subtitle">Mohon isi subjek kasus yang akan Anda
                            laporkan</h6>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="row d-flex flex-row">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="desc" id="desc-title">Deskripsi Kasus</label>
                            <h6 class="font-weight-light mt-n2" id="desc-subtitle">Jelaskan secara rinci kasus yang ingin
                                ditanyakan atau diatasi</h6>
                            <textarea name="desc" id="desc" cols="100" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-whatever="@getbootstrap">Submit Data</button>
                </div>
            </form>
        </div>
    </div>
    <!-- modal end -->
@endsection
