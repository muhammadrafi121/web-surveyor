@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">{{ $title }}</h2>
            {{-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Berikut adalah data
                lengkap jalur yang telah berhasil disi oleh petugas lapangan. Dari sini admin dapat mengubah , mengedit,
                menambah dan menghapus data yang sudah diinputkan</p> --}}
        </div>
        <!-- page card -->

        <div class="row">
            <!-- DataTales Example -->
            <div class="shadow mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn border border-dark text text-dark" data-toggle="modal"
                                data-target="#exampleModal">
                                <b>
                                    Tambah
                                </b>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Inventory</th>
                                <th>Ruas Jalur</th>
                                <th>Waktu</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $location->inventory->name }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->created_at }}</td>
                                    <td>
                                        <a href="">Cetak</a> | <a href="">Lihat</a> | <a
                                            href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal2" onclick="edit({{ $location }})">Edit</a> |
                                        <form action="/location/{{ $location->id }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Input Data Jalur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/location" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="wilayah">Pilih Inventory</label>
                            <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                            <select class="form-select form-control" id="wilayah" name="wilayah" required>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="name" class="h5 font-weight-bold">Nama Jalur</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Jalur"
                                value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal2Label">Form Input Data Jalur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit" action="" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id-edit">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="wilayah2">Pilih Inventory</label>
                            <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                            <select class="form-select form-control" id="wilayah2" name="wilayah" required>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="name2" class="h5 font-weight-bold">Nama Jalur</label>
                            <input type="text" class="form-control" id="name2" name="name" placeholder="Jalur"
                                value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
