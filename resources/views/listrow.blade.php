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
                                data-target="#exampleModal"><i class="fas fa-plus mr-2"></i><b>Tambah</b>
                            </button>
                        </div>
                    </div>
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
                                    <th>Ruas Jalur</th>
                                    <th>No Tower</th>
                                    <th>Last Update</th>
                                    <th>Penginput</th>
                                    <th>Tindakan</th>
                                    <th>Lampiran</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($rows as $row)
                                    <tr>
                                        <td>{{ $row->location->name }}</td>
                                        <td>{{ $row->firsttower->no }} - {{ $row->secondtower->no }}</td>
                                        <td>{{ $row->updated_at }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>
                                            <form action="/row/{{ $row->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="">Cetak</a> |
                                                <a href=""data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $row->id }}"
                                                    data-bs-whatever="@getbootstrap">Lihat</a> |
                                                <a href="javascript:void(0)" data-toggle="modal"
                                                    data-target="#exampleModal2"
                                                    onclick="edit({{ $row }})">Edit</a> |
                                                <button type="submit" class="link">Hapus</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary" style="border: 2px solid black"
                                                data-bs-toggle="modal"
                                                data-bs-target="#attachment-modal-{{ $row->id }}"
                                                data-bs-whatever="@getbootstrap"><i
                                                    class="fas fa-file fa-sm fa-fw mr-2"></i>Browse File</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Form Input Data ROW</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/row" method="POST">
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
                            <label class="h5 font-weight-bold" for="jalur">Pilih Jalur</label>
                            <h6 class="font-weight-light mt-n2">Pilih jalur SUTT</h6>
                            <select class="form-select form-control" id="jalur" name="jalur" required>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('jalur')
                                {{ message }}
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="notower1">No Tower 1</label>
                            <h6 class="font-weight-light mt-n2">Pilih No Tower 1</h6>
                            <select class="form-select form-control" id="notower1" name="notower1" required>
                                @foreach ($towers as $tower)
                                    <option value="{{ $tower->id }}">{{ $tower->no }}</option>
                                @endforeach
                            </select>
                            @error('notower1')
                                {{ message }}
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="notower2">No Tower 2</label>
                            <h6 class="font-weight-light mt-n2">Pilih No Tower 2</h6>
                            <select class="form-select form-control" id="notower2" name="notower2" required>
                                @foreach ($towers as $tower)
                                    <option value="{{ $tower->id }}">{{ $tower->no }}</option>
                                @endforeach
                            </select>
                            @error('notower2')
                                {{ message }}
                            @enderror
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
                    <h5 class="modal-title" id="exampleModal2Label">Form Update Data ROW</h5>
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
                            <label class="h5 font-weight-bold" for="wilayah2">Pilih Inventory</label>
                            <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                            <select class="form-select form-control" id="wilayah2" name="wilayah" required>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="jalur2">Pilih Jalur</label>
                            <h6 class="font-weight-light mt-n2">Pilih jalur SUTT</h6>
                            <select class="form-select form-control" id="jalur2" name="jalur" required>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('jalur')
                                {{ message }}
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="notower1_2">No Tower 1</label>
                            <h6 class="font-weight-light mt-n2">Pilih No Tower 1</h6>
                            <select class="form-select form-control" id="notower1_2" name="notower1" required>
                                @foreach ($towers as $tower)
                                    <option value="{{ $tower->id }}">{{ $tower->no }}</option>
                                @endforeach
                            </select>
                            @error('notower1_2')
                                {{ message }}
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="notower2_2">No Tower 2</label>
                            <h6 class="font-weight-light mt-n2">Pilih No Tower 2</h6>
                            <select class="form-select form-control" id="notower2_2" name="notower2" required>
                                @foreach ($towers as $tower)
                                    <option value="{{ $tower->id }}">{{ $tower->no }}</option>
                                @endforeach
                            </select>
                            @error('notower2_2')
                                {{ message }}
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($rows as $row)
        <div class="modal fade" id="modal-{{ $row->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $row->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title font-weight-bold" id="modalLabel{{ $row->id }}">Detail Data Lahan
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <h6 id="jalur-detail">Jalur &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :
                                    {{ $row->location->name }}
                                </h6>
                                <h6 id="tower-detail">No. Tower &nbsp;:
                                    {{ $row->firsttower->no }} - {{ $row->secondtower->no }}
                                </h6>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="detail-lahan" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th rowspan="2">NO</th>
                                            <th rowspan="2">PEMILIK</th>
                                            <th colspan="2">TANAH</th>
                                            <th colspan="5">TANAM TUMBUH</th>
                                        </tr>
                                        <tr>
                                            <th>Jenis Tanah</th>
                                            <th>Luas (m<sup>2</sup>)</th>
                                            <th>Nama Tanaman</th>
                                            <th>Umur (th)</th>
                                            <th>Tinggi (m)</th>
                                            <th>Diameter (cm)</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($row->lands as $land)
                                            @if (!$land->plants->isEmpty())
                                                @foreach ($land->plants as $plant)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $land->owner->name }}</td>
                                                        <td>{{ $land->type }}</td>
                                                        <td>{{ $land->area }}</td>
                                                        <td>{{ $plant->name }}</td>
                                                        <td>{{ $plant->age }}</td>
                                                        <td>{{ $plant->height }}</td>
                                                        <td>{{ $plant->diameter }}</td>
                                                        <td>{{ $plant->total }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $land->owner->name }}</td>
                                                    <td>{{ $land->type }}</td>
                                                    <td>{{ $land->area }}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-5">
                                <h6>Lampiran</h6>
                                @if ($row->attachment)
                                    <a href="/row/{{ $row->id }}/download" class="btn btn-primary"
                                        style="border: 2px solid black"><i class="fa-solid fa-download"></i> Download</a>
                                @else
                                    <p class="text text-danger">File Lampiran Belum Tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-target="#modal-{{ $row->id }}"
                            data-bs-toggle="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal start 5 -->
        <div class="modal fade" id="attachment-modal-{{ $row->id }}" tabindex="-1" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" action="/row/{{ $row->id }}/upload" method="POST"
                    id="attachment-form" enctype="multipart/form-data">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title font-weight-bold" id="modalLabel">Upload File Lampiran
                        </h5>
                    </div>
                    <div class="modal-body">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id_lahan" id="id-lahan" value="{{ $row->id }}">
                        <div class="form-group mb-4">
                            <h6 class="font-weight-light mt-n2">Lampiran</h6>
                            <input type="file" class="form-control" id="file" name="file"
                                placeholder="Lampiran" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- modal end 5 -->
    @endforeach
@endsection
