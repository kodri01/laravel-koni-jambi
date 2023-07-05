@extends('master')
@section('title', '- Teams')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h2>Tambah Team</h2>
            <form method="POST" action="{{ url('clubs/' . $club_id . '/teams/store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="club_id" id="club_id" value="{{ $club_id }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nameteam">Nama Team</label>
                        <input type="text" value="{{ old('nameteam') }}"
                            class="form-control @error('nameteam') is-invalid @enderror" id="nameteam" name="nameteam"
                            placeholder="Nama Team">
                        @error('nameteam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="slogan">Slogan</label>
                        <input type="text" value="{{ old('nameteam') }}"
                            class="form-control @error('slogan') is-invalid @enderror" id="slogan" name="slogan"
                            placeholder="Slogan">
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
                                @if ($game->cabang_id == $clubs->cabang_id)
                                    <option value="{{ $game->cabang_id }}">{{ ucfirst($game->game_name) }}</option>
                                @endif
                                {{-- <option value="{{ $game->cabang_id }}"> {{ $game->game_name }}
                                </option> --}}
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
                                <option value="{{ $leader->id }}">{{ $leader->name }} {{ $leader->lastname }}</option>
                            @endforeach
                        </select>
                        @error('leader')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="listeam">List Atlet</label>
                        @if (!$atlets->isEmpty())
                            <select name="listeam[]" id="listeam"
                                class="form-control @error('listeam') is-invalid @enderror" multiple="multiple">
                                <option value="">Select Atlets</option>
                                @foreach ($atlets as $atlet)
                                    <option value="{{ $atlet->id }}">{{ $atlet->name }} {{ $atlet->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('leader')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc">Deskripsi</label>
                    <textarea id="desc" class="form-control" name="desc" cols="30" rows="10"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cover">Cover Team</label>
                        <input type="file" class="form-control @error('cover') is-invalid @enderror" id="cover"
                            name="cover">
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="file">Team Logo</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                            name="file">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cabor">Cabor</label>
                        <select name="cabor" id="cabor" class="form-control">
                            @foreach ($cabors as $cabor)
                                @if ($cabor->id == $clubs->cabang_id)
                                    <option value="{{ $cabor->id }}">{{ ucfirst($cabor->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
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
        $('#listeam').select2({
            width: '100%',
            multiple: true,
            placeholder: "Select an Option",
            allowClear: true
        });
    </script>
    <script>
        // Mendengarkan perubahan pada input klub
        document.getElementById('club').addEventListener('change', function() {
            var $club_id = this.value; // Mendapatkan ID klub yang dipilih
            var caborSelect = document.getElementById('cabor');

            // Menghapus semua opsi cabang saat ini
            caborSelect.innerHTML = '';

            // Mengirim permintaan ke server untuk mendapatkan daftar cabang klub
            fetch('/clubs/' + $club_id + '/cabores')
                .then(response => response.json())
                .then(data => {
                    // Membuat opsi untuk setiap cabang dan menambahkannya ke elemen select
                    data.cabors.forEach(cabor => {
                        var option = document.createElement('option');
                        option.value = cabor.id;
                        option.textContent = cabor.name;
                        caborSelect.appendChild(option);
                    });
                });
        });
    </script>

@endsection
@endsection
