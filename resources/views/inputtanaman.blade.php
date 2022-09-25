@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Form Input Data Tanaman</h2>
            <!-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silahkan isi form berikut ini untuk menambahkan data tapak tower</p> -->
        </div>
        <!-- page form akun -->
        <div class="row bg-white d-flex shadow-lg py-4">
            <div class="row d-sm-flex">
                <div class="col-md-4 col-sm-12 mb-2">
                    <h6 class=" font-weight-bold">NAMA PEMILIK : {{ $land->owner->name }}</h6>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <form action="/plant" method="POST">
                    @csrf
                    <input type="hidden" name="land_id" value="{{ $land->id }}">
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="namatanaman" placeholder="Nama Tanaman">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="umur" placeholder="Umur Tanaman">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="tinggi" placeholder="Tinggi Tanaman">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="diameter" placeholder="Diameter Tanaman">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="jumlah" placeholder="Jumlah Tanaman">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="keterangan" placeholder="Keterangan">
                    </div>
                    <button type="submit" class="btn btn-primary bg-yellow text-dark ">Tambah Tanaman</button>
                </form>
            </div>
        </div>
    </div>
@endsection
