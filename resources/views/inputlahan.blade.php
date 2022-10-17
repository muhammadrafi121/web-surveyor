@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Data Lahan</h2>
        </div>
        <!-- page card -->

        <div class="row">
            <!-- DataTales Example -->
            <div class="shadow mb-4">
                <div class="card-body">
                    <form action="/land" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                            <select class="form-select form-control" id="wilayah" name="wilayah">
                                @can('isAdmin')
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                    @endforeach
                                @elsecan('isSurveyor')
                                    <option value="{{ $inventories->id }}">{{ $inventories->name }}</option>
                                @endcan
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
                        <div class="row d-flex flex-row">
                            <div class="col-md-6 form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Pilih Tipe Input</h6>
                                <select class="form-select form-control" id="tipe" name="tipe">
                                    <option selected>Pilih Tipe Input</option>
                                    <option value="row">ROW</option>
                                    <option value="tower">Tapak Tower</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-4" id="pilihan">
                            </div>
                        </div>
                        <input type="hidden" id="tower-row">
                        <input type="hidden" id="id-edit" name="id">
                        <input type="hidden" id="owner-id" name="owner_id">
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Nama</h6>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Nama Pemilik" required />
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Provinsi</h6>
                            <select name="provinsi" id="provinsi" class="form-control" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Kabupaten</h6>
                            <select name="kabupaten" id="kabupaten" class="form-control" required>
                                <option value="">Pilih Kabupaten</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Kecamatan</h6>
                            <select name="kecamatan" id="kecamatan" class="form-control" required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Kelurahan / Desa</h6>
                            <select name="desa" id="desa" class="form-control" required>
                                <option value="">Pilih Kelurahan / Desa</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Jenis Tanah</h6>
                            <input type="text" class="form-control" id="jenis" name="jenis"
                                placeholder="Jenis Tanah" required />
                        </div>
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Luas Tanah</h6>
                            <input type="text" class="form-control" id="luas" name="luas"
                                placeholder="Luas Tanah" required />
                        </div>
                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-primary">Submit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
