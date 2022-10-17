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
                        <a href="/land/export" class="btn btn-outline-primary font-weight-bold"><i
                                class="fas fa-upload mr-2"></i>Export</a>
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
                                        <td>
                                            <form action="/land/{{ $land->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="/land/{{ $land->id }}/print" target="_blank">Cetak</a> |
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $land->id }}"
                                                    data-bs-whatever="@getbootstrap"
                                                    onclick="setDetail({{ $land }})">Lihat</a> |
                                                <a href="javascript:void(0)" onclick="edit({{ $land }})">Edit</a> |
                                                <button type="submit" class="link">Hapus</button>
                                            </form>
                                        <td>
                                            <button class="btn-sm btn-outline-primary font-weight-bold bg-yellow"
                                                data-bs-toggle="modal" data-bs-target="#plant-modal-{{ $land->id }}"
                                                data-bs-whatever="@getbootstrap"><i
                                                    class="fas fa-plus mr-2"></i>Tambah</button>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary" style="border: 2px solid black"
                                                data-bs-toggle="modal"
                                                data-bs-target="#attachment-modal-{{ $land->id }}"
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-whatever="@getbootstrap" onclick="saveData()">Submit
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
                <form action="/land" method="POST" id="form-action" class="modal-content">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h6 id="data-inv">INV : Sumsel 1</h6>
                        <h6 id="data-jalur">Jalur : Sumsel 1</h6>
                        <h6 id="row-tower">ROW : T.71 - T.72</h6>
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel3">Form Lahan</h5>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
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
                                    <h6 id="pemilik-detail-{{ $land->id }}">Nama Pemilik &nbsp; &nbsp; &nbsp; &nbsp;:
                                        {{ $land->owner->name }}</h6>
                                    <h6 id="desa-detail-{{ $land->id }}">Desa / Kelurahan &nbsp;:
                                        {{ $land->owner->village }}</h6>
                                    <h6 id="kecamatan-detail-{{ $land->id }}">Kecamatan &nbsp; &nbsp; &nbsp; &nbsp;
                                        &nbsp; &nbsp;:
                                        {{ $land->owner->district }}</h6>
                                </div>
                                <div class="col-md-7">
                                    <h6 id="kabupaten-detail-{{ $land->id }}">Kabupaten : {{ $land->owner->regency }}
                                    </h6>
                                    <h6 id="jalur-detail-{{ $land->id }}">Jalur &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :
                                        {{ $land->tower == null ? $land->row->location->name : $land->tower->location->name }}
                                    </h6>
                                    <h6 id="tower-detail-{{ $land->id }}">No. Tower &nbsp;:
                                        {{ $land->tower == null ? $land->row->firsttower->no . '-' . $land->row->secondtower->no : $land->tower->no }}
                                    </h6>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped"
                                        id="detail-{{ $land->id }}-lahan" width="100%" cellspacing="0">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th rowspan="2">NO</th>
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
                                            @php
                                                $currLand = null;
                                            @endphp
                                            @if (!$land->plants->isEmpty())
                                                @php
                                                    $prevLand = $land;
                                                @endphp
                                                @foreach ($land->plants as $plant)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        @if ($prevLand == $currLand)
                                                            <td></td>
                                                            <td></td>
                                                        @else
                                                            <td>{{ $land->type }}</td>
                                                            <td>{{ $land->area }}</td>
                                                        @endif
                                                        <td>{{ $plant->name }}</td>
                                                        <td>{{ $plant->age }}</td>
                                                        <td>{{ $plant->height }}</td>
                                                        <td>{{ $plant->diameter }}</td>
                                                        <td>{{ $plant->total }}</td>
                                                    </tr>
                                                    @php
                                                        $currLand = $prevLand;
                                                    @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>1</td>
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
                            <div class="row my-3">
                                <div class="col-lg-5">
                                    <h6>Lampiran</h6>
                                    @if ($land->attachment)
                                        <a href="/land/{{ $land->id }}/download" class="btn btn-primary"
                                            style="border: 2px solid black"><i class="fa-solid fa-download"></i>
                                            Download</a>
                                    @else
                                        <p class="text text-danger">File Lampiran Belum Tersedia</p>
                                    @endif
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
            <!-- modal end 3 -->

            <!-- modal start 4 -->
            <div class="modal fade" id="plant-modal-{{ $land->id }}" tabindex="-1" aria-labelledby="modalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <form class="modal-content" action="/plant" method="POST" id="plant-form">
                        <div class="modal-header d-flex flex-column">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <h5 class="modal-title font-weight-bold" id="modalLabel">Input Data Tanam Tumbuh
                            </h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id_lahan" id="id-lahan" value="{{ $land->id }}">
                            <div id="table" class="table-editable">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tanaman</th>
                                            <th>Umur (th)</th>
                                            <th>Tinggi (m)</th>
                                            <th>Diameter (cm)</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-tanaman">
                                        @php
                                            $total = sizeof($land->plants);
                                            $rest = 20 - $total;
                                            $count = 0;
                                            $iter = 1;
                                        @endphp
                                        @for ($i = 0; $i < $total; $i++)
                                            <tr>
                                                <input type="hidden" name="idtanaman[]"
                                                    id="id-{{ $i }}-{{ $land->id }}"
                                                    value="{{ $land->plants[$i]->id }}">
                                                <td>{{ $iter }}</td>
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="nama-tanaman-{{ $i }}-{{ $land->id }}">
                                                    {{ $land->plants[$i]->name }}</td><input type="hidden"
                                                    name="namatanaman[]"
                                                    id="nama-{{ $i }}-{{ $land->id }}"
                                                    value="{{ $land->plants[$i]->name }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="umur-tanaman-{{ $i }}-{{ $land->id }}">
                                                    {{ $land->plants[$i]->age }}</td><input type="hidden"
                                                    name="umurtanaman[]"
                                                    id="umur-{{ $i }}-{{ $land->id }}"
                                                    value="{{ $land->plants[$i]->age }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="tinggi-tanaman-{{ $i }}-{{ $land->id }}">
                                                    {{ $land->plants[$i]->height }}</td><input type="hidden"
                                                    name="tinggitanaman[]"
                                                    id="tinggi-{{ $i }}-{{ $land->id }}"
                                                    value="{{ $land->plants[$i]->height }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="diameter-tanaman-{{ $i }}-{{ $land->id }}">
                                                    {{ $land->plants[$i]->diameter }}</td><input type="hidden"
                                                    name="diametertanaman[]"
                                                    id="diameter-{{ $i }}-{{ $land->id }}"
                                                    value="{{ $land->plants[$i]->diameter }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="jumlah-tanaman-{{ $i }}-{{ $land->id }}">
                                                    {{ $land->plants[$i]->total }}</td><input type="hidden"
                                                    name="jumlahtanaman[]"
                                                    id="jumlah-{{ $i }}-{{ $land->id }}"
                                                    value="{{ $land->plants[$i]->total }}">
                                            </tr>
                                            @php
                                                $count++;
                                                $iter++;
                                            @endphp
                                        @endfor
                                        @for ($i = 0; $i < $rest; $i++)
                                            <tr>
                                                <input type="hidden" name="idtanaman[]"
                                                    id="id-{{ $count }}-{{ $land->id }}">
                                                <td>{{ $iter }}</td>
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="nama-tanaman-{{ $count }}-{{ $land->id }}"></td>
                                                <input type="hidden" name="namatanaman[]"
                                                    id="nama-{{ $count }}-{{ $land->id }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="umur-tanaman-{{ $count }}-{{ $land->id }}"></td>
                                                <input type="hidden" name="umurtanaman[]"
                                                    id="umur-{{ $count }}-{{ $land->id }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="tinggi-tanaman-{{ $count }}-{{ $land->id }}"></td>
                                                <input type="hidden" name="tinggitanaman[]"
                                                    id="tinggi-{{ $count }}-{{ $land->id }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="diameter-tanaman-{{ $count }}-{{ $land->id }}">
                                                </td><input type="hidden" name="diametertanaman[]"
                                                    id="diameter-{{ $count }}-{{ $land->id }}">
                                                <td class="data-tanaman" contenteditable="true"
                                                    id="jumlah-tanaman-{{ $count }}-{{ $land->id }}"></td>
                                                <input type="hidden" name="jumlahtanaman[]"
                                                    id="jumlah-{{ $count }}-{{ $land->id }}">
                                            </tr>
                                            @php
                                                $count++;
                                                $iter++;
                                            @endphp
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"
                                data-bs-target="#plant-modal-{{ $land->id }}" data-bs-toggle="modal">Submit
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- modal end 4 -->
            <!-- modal start 5 -->
            <div class="modal fade" id="attachment-modal-{{ $land->id }}" tabindex="-1"
                aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content" action="/land/{{ $land->id }}/upload" method="POST"
                        id="attachment-form" enctype="multipart/form-data">
                        <div class="modal-header d-flex flex-column">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <h5 class="modal-title font-weight-bold" id="modalLabel">Upload File Lampiran
                            </h5>
                        </div>
                        <div class="modal-body">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id_lahan" id="id-lahan" value="{{ $land->id }}">
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
