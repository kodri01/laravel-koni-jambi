@include('frontend.component.header')
@include('frontend.component.menus')
<div class="main">
    {{-- <section>
        <div class="jumbotron-fluid">
            <div id="owl-carousel-front" class="owl-carousel owl-theme">
                @foreach ($events as $event)
                    <div class="col-md-3 mt-3 mb-3">
                        <div class="card rounded">
                            <img class="card-img-top" style="height: 15vw;object-fit: cover;"
                                src="{{ asset('uploads/' . $event->file) }}" alt="Card image cap">
                            <div class="card-block text-center m-3">
                                <div class="card-text">{{ $event->event_name }}</div>
                                <a href="#" class="border badge badge-info text-light p-2 mt-2">Lihat
                                    selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}
    <section>
        <div class="bg-light">
            <div class="container-fluid">
                <div class="list-news" style="margin: 0 auto; width: 90%">
                    <div class="row">
                        @foreach ($events as $event)
                            <div class="col-md-3 mt-3 mb-3">
                                <div class="card rounded">
                                    <img class="card-img-top" style="height: 15vw;object-fit: cover;"
                                        src="{{ asset('uploads/' . $event->file) }}" alt="Card image cap">
                                    <div class="card-block text-center m-3">
                                        <div class="card-text">{{ $event->event_name }}</div>
                                        <a href="#" class="border badge badge-info text-light p-2 mt-2">Lihat
                                            selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="bg-light">
            <div class="container-fluid">
                <div class="list-news" style="margin: 0 auto; width: 90%">
                    <div class="row">
                        @foreach ($games as $game)
                            <div class="col-md-3 mt-3 mb-3">
                                <div class="card rounded">
                                    <img class="card-img-top" style="height: 15vw;object-fit: cover;"
                                        src="{{ asset('uploads/' . $game->logo_game) }}" alt="Card image cap">
                                    <div class="card-block text-center m-3">
                                        <div class="card-text">{{ $game->game_name }}</div>
                                        <a href="#" class="border badge badge-info text-light p-2 mt-2">Lihat
                                            selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="bg-light">
            <div class="container-fluid">
                <div class="list-news" style="margin: 0 auto; width: 90%">
                    <div class="row">
                        @foreach ($news as $artice)
                            <div class="col-md-3 mt-3 mb-3">
                                <div class="card rounded">
                                    <img class="card-img-top" style="height: 15vw;object-fit: cover;"
                                        src="{{ asset('uploads/' . $artice->file) }}" alt="Card image cap">
                                    <div class="card-block text-center m-3">
                                        <div class="card-text">{{ $artice->title }}</div>
                                        <a href="#" class="border badge badge-info text-light p-2 mt-2">Lihat
                                            selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('frontend.component.footer')
