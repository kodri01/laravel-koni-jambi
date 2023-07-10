@extends('master')
@section('title', '- Info Club')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h3>Informasi Club</h3>
            <div class="mt-4">
                <div class="list">
                    @foreach ($lists as $club)
                        <div class="card p-2" style="background-color: rgb(248, 248, 242)">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="{{ asset('uploads/' . $club->club_file) }}" class="card-img-top img-thumnail"
                                        style="height: 250px;" alt="...">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $club->club_name }}</h4>

                                        <h5 class="card-text">
                                            Kepala Club -
                                            @foreach ($pelatih as $user)
                                                @if ($club->id_userclub == $user->pelatih_id)
                                                    {{ $user->pelatih_name }} {{ $user->pelatih_lastname }}
                                                @break
                                            @endif
                                        @endforeach
                                    </h5>
                                    <p class="card-text">{{ $club->club_desc }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="sublist mt-4">
                <h4 class="">Informasi Team</h4>
                <div class="row justify-content-center">
                    @foreach ($lists as $club)
                        @if ($club->team_id != null)
                            <div class="col-sm-3">
                                <p>
                                    <a class="btn btn-primary" data-bs-toggle="collapse"
                                        href="#collapse{{ $club->team_id }}" role="button" aria-expanded="false"
                                        aria-controls="collapse{{ $club->team_id }}">
                                        {{ $club->team_name }}
                                    </a>
                                </p>
                            </div>
                        @else
                            <div class="text-center">
                                <h3>Kamu belum memiliki team</h3>
                            </div>
                        @endif
                    @endforeach
                </div>

                @foreach ($lists as $club)
                    <div class="collapse" id="collapse{{ $club->team_id }}">
                        <div class="content-team">
                            <div class="card mb-3" style="background-color: rgb(248, 248, 242)">
                                <div class="row no-gutters">
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $club->team_name }}</h5>
                                            <p class="card-text">{{ $club->team_desc }}</p>
                                            <p class="card-text"><small class="text-body-secondary">Slogan :
                                                    {{ $club->team_slogan }}</small></p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 p-2">
                                        <img src="{{ asset('uploads/' . $club->team_file) }}"
                                            class="card-img-top img-thumnail" style="height: 250px;" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sublist mt-4">
                            <h4 class="">Anggota Team</h4>
                            <div class="content-team">
                                <div class="row justify-content-center">
                                    @foreach ($users as $user)
                                        @if ($club->leader_team == $user->id)
                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                <div class="card p-2" style="background-color: rgb(248, 248, 242)">
                                                    <div class="text-center">
                                                        <h5 class="badge badge-danger w-50">Leader Team</h5>
                                                    </div>
                                                    <img src="{{ asset('uploads/' . $user->profile_pic) }}"
                                                        class="card-img-top" alt="..." style="height:12vw;">
                                                    <div class="card-body text-center">
                                                        <p class="card-text">
                                                            <b>{{ $user->name . ' ' . $user->lastname }}</b>
                                                        </p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <small class="text-body-secondary badge badge-danger">Since
                                                            at
                                                            {{ $user->created_at }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @php
                                        $de = json_decode($club->atlet);
                                    @endphp
                                    @if ($de)
                                        @foreach ($de as $atlet)
                                            @foreach ($users as $user)
                                                @if ($atlet == $user->id)
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card p-2"
                                                            style="background-color: rgb(248, 248, 242)">
                                                            <div class="text-center">
                                                                <h5 class="badge badge-success w-50">Anggota Team
                                                                </h5>
                                                            </div>
                                                            <img src="{{ asset('uploads/' . $user->profile_pic) }}"
                                                                alt="..." class="card-img-top"
                                                                style="height:12vw;">
                                                            <div class="card-body text-center">
                                                                <p class="card-text">
                                                                    <b>{{ $user->name . ' ' . $user->lastname }}</b>
                                                                </p>
                                                            </div>
                                                            <div class="card-footer">
                                                                <small
                                                                    class="text-body-secondary badge badge-success">Since
                                                                    at
                                                                    {{ $user->created_at }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>


</div>
{{-- @endforeach --}}
@endsection
