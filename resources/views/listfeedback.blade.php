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
                            <img src="/img/alert.png" alt="" srcset="" class="m-auto w-50" />
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
        <!-- Page Heading -->
        <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Entri Feedback</h2>
            <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Ini adalah list entri
                feedback.</p>
        </div>

        <!-- page card -->
        <div class="row">
            <div class="shadow mb-4">
                <div class="card-body">
                    @if (!$messages->isEmpty())
                        <ul class="list-group list-group-flush">
                            @foreach ($messages as $message)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div class="col-8">
                                        <h4 class="h4 font-weight-bold">{{ $message->title }}</h4>
                                        <small>Dibuka oleh:</small> <small
                                            class="font-weight-bold">{{ $message->user->name }}</small> |
                                        <small>{{ $message->created_at->format('d-m-Y H:i') }}</small>
                                    </div>
                                    <div class="col-1">
                                        <a href="/feedback/{{ $message->id }}" class="btn btn-user btn-primary">Lihat</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="row d-flex justify-content-between">
                            <div class="col">
                                <center>
                                    <p class="text text-danger">Feedback tidak ditemukan!</p>
                                    <div class="col">
                                        <a href="/feedback" class="btn btn-user btn-primary">Kembali</a>
                                    </div>
                                </center>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
