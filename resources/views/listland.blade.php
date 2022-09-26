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
                                    <th>Pemilik</th>
                                    <th>Jenis Lahan</th>
                                    <th>Luas</th>
                                    <th>Penginput</th>
                                    <th>Tindakan</th>
                                    <th>Tanaman</th>
                                    <th>Lampiran</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($lands as $land)
                                    <tr>
                                        <td>{{ $land->owner->name }}</td>
                                        <td>{{ $land->type }}</td>
                                        <td>{{ $land->area }}</td>
                                        <td>{{ $land->user->name }}</td>
                                        <td>
                                            <a href="">Cetak</a> | <a href="">Lihat</a> | <a href="">Edit</a> | 
                                            <form action="/land/{{ $land->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit">Hapus</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="">Tambah</a>
                                        </td>
                                        <td>
                                            <a href="">Lampiran</a>
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
