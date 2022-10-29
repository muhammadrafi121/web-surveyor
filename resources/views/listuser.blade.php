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
                                <a href="/user" class="btn btn-primary mx-auto">Lihat Data</a>
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
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Tim</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->team ? $user->team->name . ' / ' . $user->team->inventory->name : '' }}
                                        </td>
                                        <td>
                                            <form action="/user/{{ $user->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $user->id }}"
                                                    data-bs-whatever="@getbootstrap">Lihat</a> |
                                                <a href="javascript:void(0)" onclick="edit({{ $user }})">Edit</a>
                                                @if ($user->id != 1)
                                                    | <button type="submit" class="link">Hapus</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="paginator">
                        {{ $users->links('pagination::bootstrap-4') }}
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
                    <h5 class="modal-title h5 font-weight-bold" id="exampleModalLabel">Form Input Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="$('#exampleModal').modal('hide')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/user" method="POST">
                    @method('POST')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="role">Role</label>
                            <select name="role" id="role" class="form-select form-control">
                                <option value="Administrator">Administrator</option>
                                <option value="Surveyor">Surveyor</option>
                                <option value="Client">Client</option>
                            </select>
                        </div>
                        <div class="form-group mb-4" id="team-container"></div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group mb-4">
                            <label class="h6 font-weight-bold" for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        <div class="modal fade" id="modal-{{ $user->id }}" tabindex="-1"
            aria-labelledby="modalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex flex-column">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title font-weight-bold" id="modalLabel{{ $user->id }}">Detail Data User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="name-detail-{{ $user->id }}">Nama</label>
                            <input type="text" class="form-control" id="name-detail-{{ $user->id }}"
                                value="{{ $user->name }}" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="username-detail-{{ $user->id }}">Username</label>
                            <input type="text" class="form-control" id="username-detail-{{ $user->id }}"
                                value="{{ $user->username }}" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="email-detail-{{ $user->id }}">Email</label>
                            <input type="email" class="form-control" id="email-detail-{{ $user->id }}"
                                value="{{ $user->email }}" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="role-detail-{{ $user->id }}">Role</label>
                            <input type="text" class="form-control" id="role-detail-{{ $user->id }}"
                                value="{{ $user->role }}" readonly>
                        </div>
                        <div class="form-group mb-4" id="team">
                            <label class="h5 font-weight-bold" for="team-detail-{{ $user->id }}">Tim</label>
                            <input type="text" class="form-control" id="team-detail-{{ $user->id }}"
                                value="{{ $user->team ? $user->team->name . ' / ' . $user->team->inventory->name : '' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-target="#modal-{{ $user->id }}"
                            data-bs-toggle="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
