@extends('master')
@section('title', '- Event')
@section('content')
    <div class="bg-white">
        <div class="card mb-3" style="max-width: 100%;">
            <div class="card-header">
                <h4>Detail Event</h4>
            </div>
            <div class="row g-0 m-2">
                <div class="col-md-5">
                    <img src="{{ url('uploads/' . $event->file) }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-7">
                    <div class="card-body">

                        <h2 class="card-title">{{ $event->event_name }}</h2>
                        <h6 class="card-text text-primary text-small">Waktu : {{ $startDate }} s/d {{ $endDate }}
                        </h6>
                        <br>
                        <p class="card-text">Deskripsi: <br>{{ $event->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
