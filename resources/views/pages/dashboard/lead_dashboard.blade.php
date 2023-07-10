@extends('master')
@section('title', '- Dashboard')
@section('content')
    <div class="event card">
        <div class="card-header">
            <h4>My Club</h4>
        </div>
        <div>
            <div class="card mx-2 my-2">
                @foreach ($clubs as $club)
                    <img src="{{ url('uploads/' . $club->file) }}" class="card-img-top img-responsive mx-auto"
                        style=" height:350px" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $club->club_name }}</h5>
                        <p class="card-text">{{ $club->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-4 card">
        <div class="card-header">
            <h4>My Team</h4>
        </div>
        <div>
        </div>
    </div>

@endsection
