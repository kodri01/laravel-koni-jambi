@extends('master')
@section('title', '- User')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h2>Edit User</h2>
            <form method="POST" action="{{ route('admins.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" id="firstname" name="firstname"
                            placeholder="Firstname">
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                            value="{{ $user->lastname }}" id="lastname" name="lastname" placeholder="Lastname">
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ $user->email }}" id="inputEmail4" placeholder="Email" name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="inputPassword4" name="pass"
                            placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ktp">No KTP</label>
                    <input type="text" class="form-control" value="{{ $user->no_ktp }}" id="ktp" name="ktp">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <textarea class="form-control" name="address" id="address" cols="30" rows="10">{{ $user->address }}</textarea>
                </div>
                <div class="form-group">
                    <label for="cabor">Cabang</label>
                    <select name="cabor" id="cabor" class="form-control">
                        @foreach ($cabors as $cabor)
                            <option value="{{ $cabor->id }}"
                                {{ $cabor->id == $user->cabang_id ? 'selected="selected"' : '' }}>{{ $cabor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputState">Role</label>
                        <select id="inputState" class="form-control" name="role">
                            @foreach ($role as $list)
                                <option value="{{ $list->id }}"
                                    {{ $list->id == $roleuser->role_id ? 'selected="selected"' : '' }}>
                                    {{ ucfirst($list->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="file">Foto Profile</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="filektp">Foto KTP</label>
                        <input type="file" class="form-control" id="filektp" name="filektp">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        &nbsp
                    </div>
                    @if (!empty($user->profile_pic))
                        <div class="form-group col-md-4">
                            <div class="show-image d-inline-block" id="show-image" style="width: 150px; height: auto;">
                                <img src='{{ url("uploads/$user->profile_pic") }}' class="img-fluid img-thumbnail" />
                            </div>
                        </div>
                    @endif
                    @if (!empty($user->profile_ktp))
                        <div class="form-group col-md-4">
                            <div class="show-image d-inline-block" id="show-image" style="width: 150px; height: auto;">
                                <img src='{{ url("uploads/$user->profile_ktp") }}' class="img-fluid img-thumbnail" />
                            </div>
                        </div>
                    @endif
                </div>
                <div class="button-grup">
                    <a href="{{ route('admins') }}" class="btn btn-danger m-1">Back</a>
                    <button type="submit" class="btn btn-primary m-1">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
