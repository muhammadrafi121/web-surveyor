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
                        <button type="button" class="btn border border-dark text text-dark" data-toggle="modal"
                            data-target="#exampleModal"><i class="fas fa-plus mr-2"></i><b>Tambah</b>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-outline-primary font-weight-bold" data-bs-toggle="modal"
                            data-bs-target="#exampleModal1" data-bs-whatever="@getbootstrap"><i
                                class="fas fa-download mr-2"></i>Import</button>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <a href="/row/export" class="btn btn-outline-primary font-weight-bold"><i
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
                                        @php
                                            $currLand = null;
                                            $count = 1;
                                        @endphp
                                        @foreach ($row->lands as $land)
                                            @php
                                                $prevLand = $land;
                                            @endphp
                                            @if (!$land->plants->isEmpty())
                                                @foreach ($land->plants as $plant)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        @if ($currLand && $currLand->owner == $prevLand->owner)
                                                            <td></td>
                                                        @else
                                                            <td>{{ $land->owner->name }}</td>
                                                        @endif
                                                        @if ($currLand && $currLand->type == $prevLand->type)
                                                            <td></td>
                                                        @else
                                                            <td>{{ $land->type }}</td>
                                                        @endif
                                                        <td>{{ $land->area }}</td>
                                                        <td>{{ $plant->name }}</td>
                                                        <td>{{ $plant->age }}</td>
                                                        <td>{{ $plant->height }}</td>
                                                        <td>{{ $plant->diameter }}</td>
                                                        <td>{{ $plant->total }}</td>
                                                    </tr>
                                                    @php
                                                        $currLand = $prevLand;
                                                        $count++;
                                                    @endphp
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>{{ $count }}</td>
                                                    @if ($currLand && $currLand->owner == $prevLand->owner)
                                                        <td></td>
                                                    @else
                                                        <td>{{ $land->owner->name }}</td>
                                                    @endif
                                                    @if ($currLand && $currLand->owner == $prevLand->owner && $currLand->type == $prevLand->type)
                                                        <td></td>
                                                    @else
                                                        <td>{{ $land->type }}</td>
                                                    @endif
                                                    <td>{{ $land->area }}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                @php
                                                    $currLand = $prevLand;
                                                    $count++;
                                                @endphp
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
