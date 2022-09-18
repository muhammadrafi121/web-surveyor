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
                  <h6 class=" font-weight-bold">INV :</h6>
                </div>
                <div class="col-md-4 col-sm-12 mb-2">
                  <h6 class=" font-weight-bold">JALUR :</h6>
                </div>
                <div class="col-md-4 col-sm-12 mb-2">
                  <h6 class=" font-weight-bold">TAPAK :</h6>
                </div>
              </div>
              <div class="col-md-6 mx-auto">
                <form>
                  <div class="form-group mb-4">
                    <input type="date" class=" form-control" name="tanggal" placeholder="tanggal">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="nama" placeholder="Nama Pemilik">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="alamat" placeholder="Alamat">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="desa" placeholder="Desa / Kelurahan">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="kecamatan" placeholder="Kecamatan">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="kabupaten" placeholder="Kabupaten">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="notower" placeholder="No Tower">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                     <select class="form-select form-control" id="jenis">
                        <option selected>Jenis Tanah</option>
                        <option value="1">Perkebunan</option>
                        <option value="2">Persawahan</option>
                        <option value="3">Pondok</option>
                      </select>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="luas" placeholder="Luas Tanah">
                    </input>
                  </div>
                  <button type="submit" class="btn btn-primary">Daftarkan</button>
                </form>
              </div>
              <div class="col-md-6 mx-auto">
                <form>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="name" placeholder="Nama Tanaman">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="umur" placeholder="Umur Tanaman">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="tinggi" placeholder="Tinggi Tanaman">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="diameter" placeholder="Diameter Tanaman">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="kecamatan" placeholder="Jumlah Tanaman">
                    </input>
                  </div>
                  <div class="form-group mb-4">
                    <input type="text" class=" form-control" name="keterangan" placeholder="Keterangan">
                    </input>
                  </div>
                  <button type="submit" class="btn btn-primary bg-yellow text-dark ">Daftarkan</button>
                </form>
              </div>
            </div>
          </div>
@endsection