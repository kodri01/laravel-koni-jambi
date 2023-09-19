@extends('master')
@section('title', '- Atlet')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h2>Select Atlet</h2>
            <form method="POST" action="{{ url('clubs/' . $club_id . '/atlets/selectadd') }}">
                @csrf
                <div class="form-group">
                    <label for="selectuser">Nama Atlet</label>
                    <select name="selectuser" id="selectuser" class="form-control text-capitalize">
                        @foreach ($lists as $list)
                            @if ($list->cabang_id == $clubs->cabang_id)
                                <option value="{{ $list->id }}">{{ $list->name }} {{ $list->lastname }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="cabor">Cabor</label>
                    <select name="cabor" id="cabor" class="form-control">
                        @foreach ($cabors as $cabor)
                            @if ($cabor->id == $clubs->cabang_id)
                                <option value="{{ $cabor->id }}">{{ ucfirst($cabor->name) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="button-grup">
                    <a href="{{ url('clubs/' . $club_id . '/atlets') }}" class="btn btn-danger m-1">Back</a>
                    <button type="submit" class="btn btn-primary m-1">Send</button>
                </div>
            </form>
        </div>
    </div>
@endsection
