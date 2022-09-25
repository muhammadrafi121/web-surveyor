    @extends('layouts.main')
    
    @section('content')
    <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
              <h2 class="h2 mb-3 font-weight-bold">Data Daily Report</h2>
              {{-- <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Silahkan melakukan input data sesuai dengan kebutuhan yang akan digunakan. Anda dapat memilih salah satu dari moel input data berikut ini :</p> --}}
            </div>
            <div class="row">
              <div class="col-12">
                <div class="container bg-white shadow-lg p-5">
                  <form method="POST" action="/dailyreport">
                    @csrf
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
                    </div>
                    {{-- <div class="form-group mb-4">
                      <label class="h5 font-weight-bold" for="jalur">Pilih Team</label>
                      <h6 class="font-weight-light mt-n2">Pilih Team yang bertugas</h6>
                      <select class="form-select form-control" id="jalur" name="jalur" required>
                        @foreach ($teams as $team)
                          <option value="{{ $team->id }}">{{ $team->name }} / {{ $team->inventory->name }}</option>  
                        @endforeach
                      </select>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Mulai Input</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          @endsection