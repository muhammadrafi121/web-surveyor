    @extends('layouts.main')
    
    @section('content')
    <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
              <h2 class="h2 mb-3 font-weight-bold">Data Baru</h2>
              {{-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silahkan melakukan input data sesuai dengan kebutuhan yang akan digunakan. Anda dapat memilih salah satu dari moel input data berikut ini :</p> --}}
            </div>
            <div class="row">
              <div class="col-12">
                <div class="container bg-white shadow-lg p-5">
                  <form method="POST" action="tower">
                    @csrf
                    <div class="form-group mb-4">
                      <label class="h5 font-weight-bold" for="wilayah">Pilih Inventory</label>
                      <h6 class="font-weight-light mt-n2">Pilih Inventory Wilayah</h6>
                      <select class="form-select form-control" id="wilayah" name="wilayah" required>
                        <option selected>INV SUMSEL 1</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                    <div class="form-group mb-4">
                      <label class="h5 font-weight-bold" for="jalur">Pilih Jalur</label>
                      <h6 class="font-weight-light mt-n2">Pilih jalur SUTT</h6>
                      <select class="form-select form-control" id="jalur" name="jalur" required>
                        <option selected>Jalur SUTT kV Soralangun - Muara Rupit</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Mulai Input</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          @endsection