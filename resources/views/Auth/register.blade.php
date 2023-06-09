@include('Auth.components.header')
<div class="container-fluid register-image">
    <div class="p-4">
        <div class="card p-4 rounded" style="width: 50%;margin: 0 auto;">
            <div class="login-form-title">Register Account</div>
            <form method="POST" action="{{ route('register.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="firstname">Firstname</label>
                        <input type="text" value="{{ old('firstname') }}"
                            class="form-control @error('firstname') is-invalid @enderror" id="firstname"
                            name="firstname" placeholder="Firstname">
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="lastname">Lastname</label>
                        <input type="text" value="{{ old('lastname') }}"
                            class="form-control @error('firstname') is-invalid @enderror" id="lastname" name="lastname"
                            placeholder="Lastname">
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email">Email</label>
                        <input type="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email"
                            name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ktp">No KTP</label>
                        <input type="text" class="form-control" id="ktp" name="ktp">
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
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cabor">Cabang</label>
                        <select name="cabor" id="cabor" class="form-control">
                            @foreach ($cabors as $cabor)
                                <option value="{{ $cabor->id }}">{{ $cabor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="club">Club Pilihan</label>
                        <select id="club" class="form-control" name="club_id">
                            @foreach ($clubs as $club)
                                <option value="{{ $club->id }}">{{ ucfirst($club->club_name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputState">Role</label>
                        <select id="inputState" class="form-control" name="role">
                            @foreach ($roles as $index => $list)
                                @if ($index == 3)
                                    <option value="{{ $list->id }}">{{ ucfirst($list->name) }}</option>
                                @break
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="file">Foto Profile</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                        name="file">
                    @error('file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="filektp">Foto KTP</label>
                    <input type="file" class="form-control @error('filektp') is-invalid @enderror" id="filektp"
                        name="filektp">
                    @error('filektp')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="button-grup">
                <a href="{{ url('/') }}" class="btn btn-danger m-1">Back</a>
                <button type="submit" class="btn btn-primary m-1">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
@include('Auth.components.footer')
