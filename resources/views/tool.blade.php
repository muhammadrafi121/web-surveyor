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
                            {{-- <div class="col-md-5 col-sm-12 d-flex justify-content-evenly mx-auto my-3">
                                <a href="/tower" class="btn btn-primary mx-auto">Lihat Data</a>
                                <a href="" class="btn btn-primary bg-blue mx-auto">Cetak</a>
                            </div> --}}
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
        <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Alat</h2>
            <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Ini adalah alat untuk membantu Anda mengimpor data dengan format XLSX.</p>
        </div>

        <!-- page card -->
        <div class="row">
            <div class="col-xl-6 col-lg-12 mb-4">
                <form action="/tool/import" method="POST" id="import-form" enctype="multipart/form-data" class="card m-auto" style="min-height: 12em">
                    @csrf
                    <div class="card-header d-flex flex-column px-4" style="background-color: white">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="file">Impor Data</label>
                            <h6 class="font-weight-light mt-n2">Data dapat berupa format XLSX</h6>
                            <input type="file" class="form-control" id="file" name="file" placeholder="File ms-excel (.xlsx)"
                            required />
                        </div>
                        <div class="form-group mb-4">
                            <select class="form-select form-control" id="jenis" name="jenis" required>
                                <option value="">Jenis Data</option>
                                <option value="tower">Data Tapak Tower</option>
                                <option value="row">Data RoW</option>
                                <option value="lahan">Data Lahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column px-4">
                        <button type="submit" class="btn btn-primary btn-user btn-block">Impor Data</button>
                    </div>
                </form>
            </div>

            <div class="col-xl-6 col-lg-12 mb-4">
                <form action="/tool/export" method="POST" id="export-form" class="card m-auto" style="min-height: 12em">
                    <div class="card-header d-flex flex-column px-4" style="background-color: white">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="jenis">Ekspor Data</label>
                            <h6 class="font-weight-light mt-n2">Data yang diekspor berupa format XLSX</h6>
                        </div>
                        <div class="form-group mb-4">
                            <select class="form-select form-control" id="jenis" name="jenis" required>
                                <option value="">Jenis Data</option>
                                <option value="tower">Data Tapak Tower</option>
                                <option value="row">Data RoW</option>
                                <option value="lahan">Data Lahan</option>
                            </select>
                        </div>
                        <div class="mb-4" style="height: 1em"></div>
                    </div>
                    <div class="card-body d-flex flex-column px-4">
                        <button type="submit" class="btn btn-primary btn-user btn-block">Ekspor Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
