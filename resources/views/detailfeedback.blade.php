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
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row d-flex justify-content-between">
                                <div class="col-8">
                                    <h4 class="h4 font-weight-bold">{{ $feedback->title }}</h4>
                                    <small>Dibuka oleh:</small> <small
                                        class="font-weight-bold">{{ $feedback->user->name }}</small> |
                                    <small>{{ $feedback->created_at->format('d-m-Y H:i') }}</small>
                                </div>
                                <div class="col-1">
                                    <button onclick="{{ $feedback->target == 'admin' ? 'admcontact()' : 'feedback()' }}"
                                        class="btn btn-user btn-primary">Balas</button>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <p>{{ $feedback->text }}</p>
                                </div>
                            </div>
                        </li>
                        @foreach ($feedback->childs as $message)
                            <li class="list-group-item">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12">
                                        <small>Dibalas oleh:</small> <small
                                            class="font-weight-bold">{{ $message->user->name }}</small> |
                                        <small>{{ $message->created_at->format('d-m-Y H:i') }}</small>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <p>{{ $message->text }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- modal start -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="/feedback" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Input balasan feedback
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="url" id="url">
                    <input type="hidden" name="parent" id="parent" value="{{ $feedback->id }}">
                    <input type="hidden" name="target" id="target">
                    <div class="row d-flex flex-row">
                        <div class="form-group mb-4">
                            <label class="h5 font-weight-bold" for="desc" id="desc-title">Pesan</label>
                            <textarea name="desc" id="desc" cols="100" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-whatever="@getbootstrap">Submit Data</button>
                </div>
            </form>
        </div>
    </div>
    <!-- modal end -->
@endsection
