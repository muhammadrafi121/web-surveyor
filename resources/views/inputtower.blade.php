@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Form Input Data Tapak Tower</h2>
            <!-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silahkan isi form berikut ini untuk menambahkan data tapak tower</p> -->
        </div>
        <!-- page form akun -->
        <div class="row bg-white d-flex shadow-lg py-4">
            <div class="row d-sm-flex">
                <div class="col-md-4 col-sm-12 mb-2">
                    <h6 class=" font-weight-bold">INV : {{ $tower->location->inventory->name }}</h6>
                </div>
                <div class="col-md-4 col-sm-12 mb-2">
                    <h6 class=" font-weight-bold">JALUR : {{ $tower->location->name }}</h6>
                </div>
                <div class="col-md-4 col-sm-12 mb-2">
                    <h6 class=" font-weight-bold">TAPAK : {{ $tower->no }}</h6>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <form action="/tower/{{ $tower->id }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="tower_id" value="{{ $tower->id }}">
                    @if ($land)
                        <input type="hidden" name="land_id" value="{{ $land->id }}">
                    @endif
                    {{-- <div class="form-group mb-4">
                    <input type="date" class=" form-control" name="tanggal" placeholder="Tanggal">
                    </input>
                  </div> --}}
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="nama" placeholder="Nama Pemilik"
                            @if ($land) value="{{ old('nama', $land->owner->name) }}"  
                    @else
                      value="{{ old('nama') }}" @endif>
                    </div>
                    {{-- <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="alamat" placeholder="Alamat">
                  </div> --}}
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="desa" placeholder="Desa / Kelurahan"
                            @if ($land) value="{{ old('desa', $land->owner->village) }}"  
                    @else
                      value="{{ old('desa') }}" @endif>
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="kecamatan" placeholder="Kecamatan"
                            @if ($land) value="{{ old('kecamatan', $land->owner->district) }}"  
                    @else
                      value="{{ old('kecamatan') }}" @endif>
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="kabupaten" placeholder="Kabupaten"
                            @if ($land) value="{{ old('kabupaten', $land->owner->regency) }}"  
                    @else
                      value="{{ old('kabupaten') }}" @endif>
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="notower" placeholder="No Tower"
                            value="{{ old('notower', $tower->no) }}">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="lat" placeholder="Koordinat X"
                            value="{{ old('lat', $tower->lat) }}">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="long" placeholder="Koordinat Y"
                            value="{{ old('long', $tower->long) }}">
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="towertype" placeholder="Jenis Tower"
                            value="{{ old('towertype', $tower->type) }}">
                    </div>
                    <div class="form-group mb-4">
                        <select class="form-select form-control" id="jenistanah" name="jenistanah">
                            <option value="" disabled selected>Jenis Tanah</option>
                            <option value="1" @if ($land && old('jenistanah', $land->type) == '1') selected @endif>Perkebunan</option>
                            <option value="2" @if ($land && old('jenistanah', $land->type) == '2') selected @endif>Persawahan</option>
                            <option value="3" @if ($land && old('jenistanah', $land->type) == '3') selected @endif>Pondok</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <input type="text" class=" form-control" name="luas" placeholder="Luas Tanah"
                            @if ($land) value="{{ old('luas', $land->area) }}"  
                    @else
                      value="{{ old('luas') }}" @endif>
                    </div>
                    <button type="submit" class="btn btn-primary">Daftarkan</button>
                </form>
            </div>
        </div>
    </div>
@endsection




<!-- modal start delete account -->
            {{-- <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel2">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h2 class="my-5 text-center">Apakah Anda Yakin Ingin Menghapus Akun ?</h2>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary">Ya</button>
                  </div>
                </div>
              </div>
            </div> --}}
            <!-- modal end -->