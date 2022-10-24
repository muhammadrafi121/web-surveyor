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
                                <a href="" class="btn btn-primary mx-auto">Lihat Data</a>
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

        <div class="row">
            <!-- DataTales Example -->
            <div class="col-xl-6 col-lg-12 shadow mb-4">
                <form action="/user/{{ auth()->user()->id }}" method="POST">
                    <div class="card-body">
                        <p class="h5 font-weight-bold card-title">Profile</p>
                        <hr>
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="name-data">Nama</label>
                            <input type="text" class="form-control" id="name-data" name="name-data"
                                value="{{ $user->name }}" readonly style="background-color: white">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="username-data">Username</label>
                            <input type="text" class="form-control" id="username-data" name="username-data"
                                value="{{ $user->username }}" readonly style="background-color: white">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="email-data">Email</label>
                            <input type="email" class="form-control" id="email-data" name="email-data"
                                value="{{ $user->email }}" readonly style="background-color: white">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="role-data">Role</label>
                            <input type="texxt" class="form-control" id="role-data" name="role-data"
                                value="{{ $user->role }}" readonly style="background-color: white">
                        </div>
                        @if ($user->team)
                            <div class="form-group mb-4" id="team-container">
                                <label class="h6 font-weight-bold" for="team-data">Tim</label>
                                <input type="texxt" class="form-control" id="team-data" name="team-data"
                                    value="{{ $user->team->name . ' / ' . $user->team->inventory->name }}"
                                    readonly style="background-color: white">
                            </div>
                        @endif
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="password_confirmation">Ulangi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-primary">Ganti Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
