@extends('master')
@section('title', '- Game')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h2>Edit Game</h2>
            <form method="POST" action="{{ route('games.update', $games->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Game</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $games->game_name }}" name="name" aria-describedby="name" placeholder="Nama Game">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="desc">Deskripsi</label>
                    <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" rows="3" name="desc">{{ $games->game_description }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rule">Rules</label>
                    <textarea class="form-control @error('rule') is-invalid @enderror" id="rule" rows="3" name="rule">{{ $games->rules }}</textarea>
                    @error('rule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cabor">Cabor</label>
                    <select name="cabor" id="cabor" class="form-control">
                        @foreach ($cabors as $cabor)
                            @if ($cabor->id == $games->cabang_id)
                                <option value="{{ $cabor->id }}">{{ ucfirst($cabor->name) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Gambar</label>
                    <input type="file" class="form-control" id="file" name="file" aria-describedby="file">
                </div>
                <div class="form-group">
                    <label for="filelogo">Logo Game</label>
                    <input type="file" class="form-control" id="filelogo" name="filelogo" aria-describedby="filelogo">
                </div>
                @if (!empty($games->image_game))
                    <div class="form-group">
                        <div class="show-image d-inline-block" id="show-image" style="width: 150px; height: auto;">
                            <img src='{{ url("uploads/$games->image_game") }}' class="img-fluid img-thumbnail" />
                        </div>
                    </div>
                @endif
                @if (!empty($games->logo_game))
                    <div class="form-group">
                        <div class="show-image d-inline-block" id="show-image" style="width: 150px; height: auto;">
                            <img src='{{ url("uploads/$games->logo_game") }}' class="img-fluid img-thumbnail" />
                        </div>
                    </div>
                @endif
                <div class="button-grup">
                    <a href="{{ route('games') }}" class="btn btn-danger m-1">Back</a>
                    <button type="submit" class="btn btn-primary m-1">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
