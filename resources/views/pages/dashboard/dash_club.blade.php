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
            @if (Auth::user()->active_atlet == 0)
                <form method="POST" class="d-inline" action="{{ url('dashboard/joinClub/' . $club->slug . '/insert') }}">
                    {{ csrf_field() }}
                    <button class="rounded m-2 btn btn-primary btn-sm text-light p-2">Join Now!</button>
                </form>
                <a href="{{ url('infoclub') }}" class="btn btn-warning">Informasi club</a>
            @else
                <div>
                    <a href="{{ url('infoclub') }}" class="btn btn-warning">Informasi club</a>
                </div>
            @endif
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>
@endsection
