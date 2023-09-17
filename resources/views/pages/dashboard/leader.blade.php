@extends('master')
@section('title', '- Dasboards')
@section('content')
    <div class="row mb-3 p-2 align-content-between">
        <a href="{{ route('cabors.index') }}" class="btn col ml-2 container rounded"
            style="height: 130px; background-color:#de3230; color:white">
            <h4 class="mt-2 text-left">Total Cabor</h4>
            <h1 class="text-center">{{ $cabor }}</h1>
        </a>
        <a href="{{ route('laporan.index') }}" class="btn col ml-2 mr-2 container rounded"
            style="background-color:#f0cc04; color:white">
            <h4 class="mt-2 text-left">Total Atlet</h4>
            <h1 class="text-center">{{ $atlet }}</h1>
        </a>
        <a href="{{ route('laporan.index') }}" class="btn col container rounded"
            style="background-color:#41c5b8; color:white">
            <h4 class="mt-2 text-left">Total Pelatih</h4>
            <h1 class="text-center">{{ $pelatih }}</h1>
        </a>
        <a href="{{ route('clubs.index') }}" class="btn col ml-2 mr-2 container rounded"
            style="background-color:#0174aa; color:white">
            <h4 class="mt-2 text-left">Total Club</h4>
            <h1 class="text-center">{{ $club }}</h1>
        </a>
    </div>
    <div class="row mb-4 p-2 align-content-between">
        <a href="{{ route('laporan.index') }}" class="btn col ml-2 container rounded"
            style="height: 130px;background-color:#0174aa; color:white">
            <h4 class="mt-2 text-left">Total Team</h4>
            <h1 class="text-center">{{ $team }}</h1>
        </a>
        <a href="{{ route('awards.index') }}" class="btn col ml-2 mr-2 container rounded "
            style="background-color:#41c5b8; color:white">
            <h4 class="mt-2 text-left">Total Award</h4>
            <h1 class="text-center">{{ $award }}</h1>
        </a>
        <a href="{{ route('games') }}" class="btn col container rounded" style="background-color:#f0cc04; color:white">
            <h4 class="mt-2 text-left">Total Game</h4>
            <h1 class="text-center">{{ $game }}</h1>
        </a>
        <a href="{{ route('events.index') }}" class="btn col ml-2 mr-2 container rounded"
            style="background-color:#de3230; color:white">
            <h4 class="mt-2 text-left">Total Event</h4>
            <h1 class="text-center">{{ $event }}</h1>
        </a>
    </div>


    <div class="row">
        @if (count($teamm) > 0)
            <div class="col-sm-6">
                <div class="team">
                    <div class="card shadow-sm rounded">
                        <div class="card-header">
                            <h4>List Team</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($teamm as $team)
                                    <li class="list-group-item">{{ $team->team_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (count($clubb) > 0)
            <div class="col-sm-6">
                <div class="club">
                    <div class="card shadow-sm rounded">
                        <div class="card-header">
                            <h4>List Club</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($clubb as $club)
                                    <li class="list-group-item">{{ $club->club_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@section('script-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <Script>
        $(document).ready(function() {
            $("#owl-carousel").owlCarousel({
                autoplay: true,

                slideSpeed: 300,
                paginationSpeed: 400,
                items: 1,
                itemsDesktop: false,
                itemsDesktopSmall: false,
                itemsTablet: false,
                itemsMobile: false,
                loop: true,
                lazyLoad: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                    768: {
                        items: 1,
                    }
                }
            });
        });
    </script>
@endsection
@endsection
