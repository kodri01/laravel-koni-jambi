@extends('master')
@section('title', '- Club')
@section('content')

    <div class="card text-center">
        <div class="card-header">
            <h3>Detail Clubs</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title text-uppercase">{{ $club->club_name }}</h5>
            <div class="row g-0 justify-content-center m-4">
                <div class="col-md-4">
                    <img src="{{ url('uploads/' . $club->file) }}" class="img-fluid rounded mx-auto" alt="...">
                </div>
            </div>

            <p class="card-text"> {{ $club->description }}
            </p>
            <form method="POST" action="{{ url('dashboard/joinClub/' . $club->slug . '/insert') }}" class="m-1">
                {{ csrf_field() }}
                <button class="rounded m-2 btn btn-primary text-light p-2">Join Now!</button>
            </form>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>
@endsection
