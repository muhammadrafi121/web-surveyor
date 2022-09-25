@extends('layouts.main')

@section('content')
    <div class="container-fluid">
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
                            <button type="button" class="btn border border-dark text text-dark" data-toggle="modal" data-target="#exampleModal">
                                <b>
                                    Tambah
                                </b>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Inventory</th>
                                    <th>Waktu</th>
                                    {{-- <th>Penginput</th> --}}
                                    <th>Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td>{{ $inventory->name }}</td>
                                        <td>{{ $inventory->created_at }}</td>
                                        {{-- <td>{{ $inventory->user->name }}</td> --}}
                                        <td>
                                            <a href="">Cetak</a> | <a href="">Lihat</a> | <a href="">Edit</a> | 
                                            <form action="/inventory/{{ $inventory->id }}" method="POST">
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
    </div>
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Input Data Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/inventory" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="name" class="col-md-4">Inventory</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Inventory" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Input Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
