@extends('master')
@section('title', '- Teams')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h2>Edit Team</h2>
            <form method="POST" action="{{ url('clubs/' . $club_id . '/teams/update/' . $team->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nameteam">Nama Team</label>
                        <input type="text" class="form-control @error('nameteam') is-invalid @enderror"
                            value="{{ $team->team_name }}" id="nameteam" name="nameteam" placeholder="Nama Team">
                        @error('nameteam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="slogan">Slogan</label>
                        <input type="text" class="form-control @error('slogan') is-invalid @enderror"
                            value="{{ $team->slogan }}" id="slogan" name="slogan" placeholder="Slogan">
                        @error('slogan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="listgame">List Game</label>
                        <select name="listgame" id="listgame" class="form-control @error('listgame') is-invalid @enderror">
                            @foreach ($games as $game)
                                <option value="{{ $game->id }}"
                                    {{ $game->id == $team->games ? 'selected="selected"' : '' }}>{{ $game->game_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('listgame')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="leader">Leader Team</label>
                        <select name="leader" id="leader" class="form-control @error('leader') is-invalid @enderror">
                            @foreach ($atlets as $leader)
                                <option value="{{ $leader->id }}"
                                    {{ $leader->id == $team->leader_team ? 'selected="selected"' : '' }}>
                                    {{ $leader->name }}</option>
                            @endforeach
                        </select>
                        @error('leader')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="listeam">List Atlet</label>
                        <select name="listeam[]" id="listeam" class="form-control @error('listeam') is-invalid @enderror"
                            multiple="multiple">
                            @foreach ($atlets as $atlet)
                                <option value="{{ $atlet->id }}"
                                    {{ in_array($atlet->id, $atletarr) ? 'selected' : '' }}>{{ $atlet->name }}</option>
                            @endforeach
                        </select>
                        @error('leader')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc">Deskripsi</label>
                    <textarea id="desc" class="form-control" name="desc" cols="30" rows="10">{{ $team->desc }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cover">Cover Team</label>
                        <input type="file" class="form-control" id="cover" name="cover">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="file">Team Logo</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cabor">Cabor</label>
                        <select name="cabor" id="cabor" class="form-control">
                            @foreach ($cabors as $cabor)
                                @if ($cabor->id == $team->cabang_id)
                                    <option value="{{ $cabor->id }}">{{ ucfirst($cabor->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    @if (!empty($team->file))
                        <div class="form-group col-md-4">
                            <div class="show-image d-inline-block" id="show-image" style="width: 150px; height: auto;">
                                <img src='{{ url("uploads/$team->file") }}' class="img-fluid img-thumbnail" />
                            </div>
                        </div>
                    @endif
                    @if (!empty($team->cover))
                        <div class="form-group col-md-4">
                            <div class="show-image d-inline-block" id="show-image" style="width: 150px; height: auto;">
                                <img src='{{ url("uploads/$team->cover") }}' class="img-fluid img-thumbnail" />
                            </div>
                        </div>
                    @endif
                </div>
                <div class="button-grup">
                    <a href="{{ url('clubs/' . $club_id . '/teams') }}" class="btn btn-danger m-1">Back</a>
                    <button type="submit" class="btn btn-primary m-1">Save</button>
                </div>
            </form>
        </div>
    </div>
@section('script-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script>
        var users = {!! json_encode($team->toArray()) !!};
        $('#listeam').select2({
            width: '100%',
            multiple: true,
            placeholder: "Select an Option",

        }).trigger('change.select2');
    </script>
@endsection
@endsection
