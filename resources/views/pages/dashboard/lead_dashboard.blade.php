@extends('master')
@section('title', '- Dashboard')
@section('content')
    <div class="event card">
        <div class="card-header">
            <h4>My Club</h4>
        </div>
        <div>
            @foreach ($clubs as $club)
                <div class="card mx-2 my-2">
                    <img src="{{ url('uploads/' . $club->file) }}" class="card-img-top img-responsive mx-auto"
                        style="width: auto; height:350px" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $club->club_name }}</h5>
                        <p class="card-text">{{ $club->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="event card">
        <div class="card-header">
            <h4>My Team</h4>
        </div>
        <div>
            <div class="card mx-2 my-2">
                <div class="row justify-content-center">
                    @foreach ($teams as $team)
                        <div class="col-sm-6 col-md-4 col-lg-4 my-3">
                            <img src="{{ url('uploads/' . $team->file) }}" class="card-img-top img-responsive mx-auto"
                                style="width: auto; height:150px" alt="...">
                            <div class="my-3">
                                <h5 class="card-title">{{ $team->team_name }}</h5>
                                <p class="card-text">{{ $team->desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
