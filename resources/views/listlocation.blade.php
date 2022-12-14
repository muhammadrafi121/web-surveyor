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
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn border border-dark text text-dark" data-toggle="modal"
                        data-target="#exampleModal"><i class="fas fa-plus mr-2"></i><b>Tambah</b>
                    </button>
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
                                            <form action="/location/{{ $location->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="">Cetak</a> |
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $location->id }}"
                                                    data-bs-whatever="@getbootstrap">Lihat</a> |
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal2"
                                                    onclick="edit({{ $location }})">Edit</a> |
                                                <button type="submit" class="link">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="paginator">
                        {{ $locations->links('pagination::bootstrap-4') }}
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
                            <input type="text" class="form-control" id="name2" name="name"
                                placeholder="Jalur" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($locations as $location)
        <div class="modal fade" id="modal-{{ $location->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $location->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title font-weight-bold" id="modalLabel{{ $location->id }}">Detail Data Jalur :
                            {{ $location->name }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h6>Data RoW</h6>
                        </center>
                        <div class="row my-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="detail-row" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Jalur</th>
                                            <th>No. Tower</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($location->rows as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $location->name }}</td>
                                                <td>{{ $row->firsttower->no }} - {{ $row->secondtower->no }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row my-3">
                            <center>
                                <h6>Data Tapak Tower</h6>
                            </center>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="detail-tower" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Jalur</th>
                                            <th>No. Tower</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($location->towers as $tower)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $location->name }}</td>
                                                <td>{{ $tower->no }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-target="#modal-{{ $location->id }}"
                            data-bs-toggle="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
