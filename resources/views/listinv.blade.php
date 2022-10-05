@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div id="none" onclick="myFunction()"
                style="position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); ">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column">
                            <img src="img/alert.png" alt="" srcset="" class="m-auto w-50" />
                            <h2 class="mx-auto mt-4 font-weight-bold">{{ session('message') }}</h2>
                            <div class="col-md-5 col-sm-12 d-flex justify-content-evenly mx-auto my-3">
                                <a href="http://" class="btn btn-primary mx-auto">Lihat Data</a>
                                <a href="http://" class="btn btn-primary bg-blue mx-auto">Cetak</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function myFunction() {
                    document.getElementById("none").style.display = "none";
                }
            </script>
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
                                data-target="#exampleModal"><i
                                class="fas fa-plus mr-2"></i><b>Tambah</b>
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
                                        <td>{{ $inventory->updated_at }}</td>
                                        {{-- <td>{{ $inventory->user->name }}</td> --}}
                                        <td>
                                            <form action="/inventory/{{ $inventory->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="">Cetak</a> | 
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $inventory->id }}"
                                                    data-bs-whatever="@getbootstrap">Lihat</a> | 
                                                <a href="javascript:void(0)" data-toggle="modal"
                                                    data-target="#exampleModal2"
                                                    onclick="edit({{ $inventory }})">Edit</a> |
                                                <button type="submit" class="link">Hapus</button>
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
                            <label class="h5 font-weight-bold" for="name">Inventory</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Inventory"
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
                    <h5 class="modal-title" id="exampleModal2Label">Form Edit Data Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit" action="" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id-edit" name="id">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="name2">Inventory</label>
                            <input type="text" class="form-control" id="name2" name="name"
                                placeholder="Inventory" value="{{ old('name', $inventory->name) }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($inventories as $inventory)
        <div class="modal fade" id="modal-{{ $inventory->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $inventory->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title font-weight-bold" id="modalLabel{{ $inventory->id }}">Detail Data INV :
                            {{ $inventory->name }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row my-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="detail-lahan" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Jalur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventory->locations as $location)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $location->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-target="#modal-{{ $inventory->id }}"
                            data-bs-toggle="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
