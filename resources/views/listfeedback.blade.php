@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row d-sm-flex flex-column justify-content-between mb-4 px-lg-4">
            <h2 class="h2 mb-3 font-weight-bold">Entri Feedback</h2>
            <p class="font-weight-light mt-lg-3 d-none d-xl-block d-lg-block d-md-block d-xl-none">Ini adalah list entri
                feedback.</p>
        </div>

        <!-- page card -->
        <div class="row">
            <div class="shadow">
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
