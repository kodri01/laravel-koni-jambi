@extends('master')
@section('title', '- Users')
@section('content')
    <div class="container-fluid">
        <div class="bg-white rounded p-3 mb-3">
            <h2 class="color-title mt-1 mb-1">Laporan KONI</h2>
        </div>
        <div class="wrapper-table p-3 bg-white rounded">
            <div class="text-right m-3">
                <a href="" class="btn btn-primary">Export to Excel</a>
            </div>
            <div class="table-responsive-sm">
                <table class="table table-hover table-striped"> <?php /* */?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($lists as $users)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $users->name }}</td>
                                <td>{{ $users->email }}</td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $lists->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
