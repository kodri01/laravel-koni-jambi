@extends('master')
@section('title', '- Teams')
@section('content')
    <div class="container-fluid">
        <div class="bg-white rounded p-3 mb-2">
            <h2 class="color-title mt-1 mb-1">List Team</h2>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="wrapper-table p-3 bg-white rounded">
            <div class="w-100 mt-3 mb-3 text-right">
                <a href="{{ route('clubs.index') }}" class="btn btn-danger m-1">Back</a>
                @can('teams-create')
                    <a class="btn btn-primary" href="{{ url('clubs/' . $club_id . '/teams/create') }}">Tambah Team</a>
                @endcan
            </div>
            <div class="table-responsive-sm">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Team</th>
                            <th>Team Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($teams as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->team_name }}</td>
                                <td>
                                    @if (!empty($list->file))
                                        <img style="width: 50px; height: auto;" class="img-thumbnail"
                                            src="{{ asset('uploads/' . $list->file) }}" />
                                    @else
                                        <p class="text-center">No image</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @can('teams-edit')
                                            <a href="{{ url('clubs/' . $club_id . '/teams/edit/' . $list->id) }}"
                                                class="badge badge-primary p-2 m-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('teams-delete')
                                            <form method="POST"
                                                action="{{ url('clubs/' . $club_id . '/teams/delete/' . $list->id) }}"
                                                class="m-1">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="badge badge-danger border-0 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
