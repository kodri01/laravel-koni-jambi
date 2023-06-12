@extends('master')
@section('title', '- Atlet')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h2>Tambah Atlet</h2>
            <form method="POST" action="{{ url('clubs/' . $club_id . '/atlets/store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="firstname">Firstname</label>
                        <input type="text" value="{{ old('firstname') }}"
                            class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname"
                            placeholder="Firstname">
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="lastname">Lastname</label>
                        <input type="text" value="{{ old('lastname') }}"
                            class="form-control @error('firstname') is-invalid @enderror" id="lastname" name="lastname"
                            placeholder="Lasname">
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" value="{{ old('tgl_lahir') }}"
                            class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir">
                        @error('tgl_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="no_telp">No Telpon</label>
                        <input type="text" class="form-control" id="no_telp" placeholder="Masukan Nomor Telpon"
                            name="no_telp">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="ktp">No KTP</label>
                        <input type="text" class="form-control @error('ktp') is-invalid @enderror" id="ktp"
                            name="ktp" placeholder="Masukan Nomor KTP">
                        @error('ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="no_kk">No KK</label>
                        <input type="text" class="form-control" id="no_kk" placeholder="Masukan Nomor Kartu Keluarga"
                            name="no_kk">
                        @error('no_kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" id="inputEmail4" placeholder="Email"
                            name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control @error('pass') is-invalid @enderror" id="pass"
                            name="pass" placeholder="Password">
                        @error('pass')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <textarea class="form-control" name="address" id="address" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="cabor">Cabang</label>
                    <select name="cabor" id="cabor" class="form-control">
                        @foreach ($cabors as $cabor)
                            @if ($cabor->id == $clubs->cabang_id)
                                <option value="{{ $cabor->id }}">{{ ucfirst($cabor->name) }}</option>
                            @endif
                            {{-- <option value="{{ $cabor->id }}">{{ $cabor->name }}</option> --}}
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="file">Foto Profile</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                            name="file">
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="filektp">Foto KTP</label>
                        <input type="file" class="form-control @error('filektp') is-invalid @enderror" id="filektp"
                            name="filektp">
                        @error('filektp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="button-grup">
                    <a href="{{ url('clubs/' . $club_id . '/atlets') }}" class="btn btn-danger m-1">Back</a>
                    <button type="submit" class="btn btn-primary m-1">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
