@extends('master')
@section('title', '- Award')
@section('content')
    <div class="bg-white">
        <div class="card mb-3" style="max-width: 100%;">
            <div class="card-header">
                <h4>Detail Award</h4>
            </div>
            <div class="row g-0 m-2">
                <div class="col-md-5">
                    <img src="{{ url('uploads/' . $award->award_logo) }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h2 class="card-title">{{ $award->award_name }}</h2>
                        <p class="card-text">{{ $award->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
