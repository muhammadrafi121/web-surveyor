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
            <h2 class="h2 mb-3 font-weight-bold">Data Lahan</h2>

            <div class="row d-flex flex-column flex-lg-row justify-content-between">
                <div class="d-flex flex-row col-md-8 col-sm-12">
                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-outline-primary font-weight-bold" onclick="tambah()"><i
                                class="fas fa-plus mr-2"></i>Tambah</button>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal"
                            data-bs-target="#exampleModal1" data-bs-whatever="@getbootstrap"><i
                                class="fas fa-download mr-2"></i>Import</button>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal"
                            data-bs-target="#exampleModal2" data-bs-whatever="@getbootstrap"><i
                                class="fas fa-upload mr-2"></i>Export</button>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 d-flex flex-column flex-lg-row mt-3 mt-md-0 mt-lg-0 mt-xl-0">
                    <p class="my-auto">Filter Berdasarkan :</p>
                    <select class="col-md-6 col-sm-12 form-select form-control ml-lg-2 my-auto" id="penginput">
                        <option selected>Semua Jalur</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
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
                                    <th>Pemilik</th>
                                    <th>Jenis Lahan</th>
                                    <th>Luas</th>
                                    <th>Tim</th>
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
                                        <td><a href="">Cetak</a>| <a href="" data-bs-toggle="modal"
                                                data-bs-target="#modal-{{ $land->id }}"
                                                data-bs-whatever="@getbootstrap">Lihat</a>| <a href="javascript:void(0)"
                                                onclick="edit({{ $land }})">Edit</a>|
                                            <form action="/land/{{ $land->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit">Hapus</button>
                                            </form>
                                        <td>
                                            <button class="btn-sm btn-outline-primary font-weight-bold bg-yellow"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                data-bs-whatever="@getbootstrap"><i
                                                    class="fas fa-plus mr-2"></i>Tambah</button>
                                        </td>
                                        <td>
                                            <a href="" class="btn-primary"><i
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
        <!-- modal start -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input Data Lahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/land" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                                <select class="form-select form-control" id="wilayah" name="wilayah">
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                    @endforeach
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal3" data-bs-whatever="@getbootstrap" onclick="saveData()">Submit
                            Data</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->
        <!-- modal start 2 -->
        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h6 id="data-inv">INV : Sumsel 1</h6>
                        <h6 id="data-jalur">Jalur : Sumsel 1</h6>
                        <h6 id="row-tower">ROW : T.71 - T.72</h6>
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel3">Form Lahan</h5>
                    </div>
                    <div class="modal-body">
                        <form action="/land" method="POST" id="form-action">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="tower-row">
                            <input type="hidden" id="id-edit" name="id">
                            <input type="hidden" id="owner-id" name="owner_id">
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Nama</h6>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Nama Pemilik" required />
                            </div>
                            {{-- <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Alamat</h6>
                                <input type="text" class="form-control" name="name" placeholder="Alamat" required/>
                            </div> --}}
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Desa</h6>
                                <input type="text" class="form-control" id="desa" name="desa"
                                    placeholder="Desa / Kelurahan" required />
                            </div>
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Kecamatan</h6>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                    placeholder="Kecamatan" required />
                            </div>
                            <div class="form-group mb-4">
                                <h6 class="font-weight-light mt-n2">Kabupaten</h6>
                                <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                    placeholder="Kabupaten" required />
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-target="#exampleModalToggle3"
                            data-bs-toggle="modal">Submit Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end 2 -->
        <!-- modal start 3 -->
        @foreach ($lands as $land)
            <div class="modal fade" id="modal-{{ $land->id }}" tabindex="-1"
                aria-labelledby="modalLabel{{ $land->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-column">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <h5 class="modal-title font-weight-bold" id="modalLabel{{ $land->id }}">Detail Data Lahan
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <h6 id="pemilik-detail">Nama Pemilik &nbsp; &nbsp; &nbsp; &nbsp;: {{ $land->owner->name }}</h6>
                                    <h6 id="desa-detail">Desa / Kelurahan &nbsp;: {{ $land->owner->village }}</h6>
                                    <h6 id="kecamatan-detail">Kecamatan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: {{ $land->owner->district }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <h6 id="kabupaten-detail">Kabupaten : {{ $land->owner->regency }}</h6>
                                    <h6 id="jalur-detail">Jalur &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $land->tower == null ? $land->row->location->name : $land->tower->location->name }}</h6>
                                    <h6 id="tower-detail">No. Tower &nbsp;: {{ $land->tower == null ? $land->row->firsttower->no . '-' . $land->row->secondtower>no : $land->tower->no }}</h6>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="detail-lahan" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th colspan="2">TANAH</th>
                                                <th colspan="5">TANAM TUMBUH</th>
                                            </tr>
                                            <tr>
                                                <th>Jenis Tanah</th>
                                                <th>Luas (m<sup>2</sup>)</th>
                                                <th>Nama Tanaman</th>
                                                <th>Umur</th>
                                                <th>Tinggi</th>
                                                <th>Diameter</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$land->plants->isEmpty())
                                                @foreach ($land->plants as $plant)
                                                    <tr>
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
                                                    <td>{{ $land->type }}</td>
                                                    <td>{{ $land->area }}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-target="#modal-{{ $land->id }}"
                                data-bs-toggle="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- modal end 3 -->
    </div>
@endsection
