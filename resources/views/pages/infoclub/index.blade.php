@extends('master')
@section('title', '- Info Club')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            @foreach ($lists as $club)
                <h3>Informasi Club</h3>
                <div class="mt-4">
                    <div class="list">
                        <div class="card p-2 " style="background-color: rgb(248, 248, 242)">
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
                                            @foreach ($lists as $list)
                                                @foreach ($user as $user)
                                                    @if ($list->id_userclub == $user->id)
                                                        {{ $user->name }} {{ $user->lastname }}
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </h5>
                                        <p class="card-text">{{ $club->club_desc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sublist mt-4">
                        <h4 class="">Informasi Team</h4>
                        <div class="content-team">

                            <div class="card mb-3" style="background-color: rgb(248, 248, 242)">
                                <div class="row no-gutters">
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $club->team_name }}</h5>
                                            <p class="card-text">{{ $club->team_desc }}
                                            </p>
                                            <p class="card-text"><small class="text-body-secondary">Slogan :
                                                    {{ $club->team_desc }}</small></p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 p-2">
                                        <img src="{{ asset('uploads/' . $club->team_file) }}"
                                            class="card-img-top img-thumnail" style="height: 250px;" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sublist mt-4">
                        <h4 class="">Anggota Team</h4>
                        <div class="content-team">
                            <div class="row g-3">
                                @foreach ($users as $user)
                                    @if ($club->leader_team == $user->id)
                                        <div class="col">
                                            <div class="card p-2" style="background-color: rgb(248, 248, 242)">
                                                <div class="text-center">
                                                    <h5 class="badge badge-danger w-50">Leader Team</h5>
                                                </div>
                                                <img src="{{ asset('uploads/' . $user->profile_pic) }}" class="card-img-top"
                                                    alt="..." style="height:12vw;">
                                                <div class="card-body text-center">
                                                    <p class="card-text"><b>
                                                            {{ $user->name . ' ' . $user->lastname }}</b>
                                                    </p>
                                                </div>
                                                <div class="card-footer ">
                                                    <small class="text-body-secondary badge badge-danger">Since at
                                                        {{ $user->created_at }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @foreach ($lists as $item)
                                    @php
                                        $de = json_decode($item->atlet);
                                    @endphp
                                    @foreach ($de as $atlet)
                                        @foreach ($users as $user)
                                            @if ($atlet == $user->id)
                                                <div class="col">
                                                    <div class="card p-2" style="background-color: rgb(248, 248, 242)">
                                                        <div class="text-center">
                                                            <h5 class="badge badge-success w-50">Anggota Team</h5>
                                                        </div>
                                                        <img src="{{ asset('uploads/' . $user->profile_pic) }}"
                                                            alt="..." class="card-img-top" style="height:12vw;">
                                                        <div class="card-body text-center">
                                                            <p class="card-text">
                                                                <b>{{ $user->name . ' ' . $user->lastname }} </b>
                                                            </p>
                                                        </div>
                                                        <div class="card-footer ">
                                                            <small class="text-body-secondary badge badge-success">Since at
                                                                {{ $user->created_at }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endsection
