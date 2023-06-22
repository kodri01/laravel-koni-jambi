@extends('master')
@section('title', '- Laporan')
@section('content')
    <div class="">
        <div class="bg-white rounded p-3 mb-3">
            <h2 class="color-title mt-1 mb-1">Laporan KONI</h2>
        </div>
        <div class="wrapper-table bg-white rounded">
            <div class="w-100 ml-3">
                <div class="row">
                    <div class="col-sm-1 mt-3">
                        <a href="#tableAtlet" id="btnAtlet" class="btn btn-primary">Data Atlet</a>
                    </div>
                    <div class="col-sm-1 mt-3">
                        <a href="#tableTeam" id="btnTeam" class="btn btn-primary">Data Team</a>
                    </div>
                    <div class="col-sm-1 mt-3 ml-1">
                        <a href="#tablePelatih" id="btnPelatih" class="btn btn-primary">Data Pelatih</a>
                    </div>

                </div>
            </div>

            <!-- Tabel Atlet -->
            <div id="tableAtlet" class="table-responsive-xxl container-fluid">
                <a href="{{ url('/export/atlet') }}" class="btn btn-danger mb-2 mt-3"> Export to
                    <x-fileicon-microsoft-excel style="width: 20px; height:20px;" />
                </a>
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama lengkap</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor Telepon</th>
                            <th>Nomor KK</th>
                            <th>Nomor KTP</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Clubs</th>
                            <th>Cabors</th>
                            <th>Profil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($atlet as $atlet)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $atlet->name }} {{ $atlet->lastname }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $atlet->tgl_lahir)->format('d M Y') }}
                                </td>
                                <td>{{ $atlet->no_telp }}</td>
                                <td>{{ $atlet->no_kk }}</td>
                                <td>{{ $atlet->no_ktp }}</td>
                                <td class="text-capitalize">{{ $atlet->address }}</td>
                                <td>{{ $atlet->email }}</td>
                                <td>{{ $atlet->club_name }}</td>
                                <td>{{ $atlet->cabang }}</td>
                                <td>
                                    @if (!empty($atlet->profile_pic))
                                        <img style="width: 50px; height: auto;" class="img-thumbnail text-center"
                                            src="{{ asset('uploads/' . $atlet->profile_pic) }}" alt="Image News" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tabel Team -->
            <div id="tableTeam" class="table-responsive-sm container-fluid">
                <a href="{{ url('/export/team') }}" class="btn btn-danger mb-2 mt-3"> Export to
                    <x-fileicon-microsoft-excel style="width: 20px; height:20px;" />
                </a>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Clubs</th>
                            <th>Nama Team</th>
                            <th>Slogan Team</th>
                            <th>Team Leader</th>
                            <th>Anggota Team</th>
                            <th>Cabors</th>
                            <th>Logo Team</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($teams as $team)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $team->club_name }}</td>
                                <td>{{ $team->team_name }}</td>
                                <td>{{ $team->slogan }}</td>
                                <td>{{ $team->leader_team }}</td>
                                <td>
                                    <ul>
                                        @foreach ($team->anggota_team as $anggota)
                                            <li>{{ $anggota->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $team->cabang }}</td>
                                <td>
                                    @if (!empty($team->file))
                                        <img style="width: 50px; height: auto;" class="img-thumbnail text-center"
                                            src="{{ asset('uploads/' . $team->file) }}" alt="Image News" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Tabel Pelatih -->
            <div id="tablePelatih" class="table-responsive-xl container-fluid">
                <a href="{{ url('/export/pelatih') }}" class="btn btn-danger mb-2 mt-3"> Export to
                    <x-fileicon-microsoft-excel style="width: 20px; height:20px;" />
                </a>

                <div class="table-responsive-xxl">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama lengkap</th>
                                <th>Tanggal Lahir</th>
                                <th>Nomor Telepon</th>
                                <th>Nomor KK</th>
                                <th>Nomor KTP</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Clubs</th>
                                <th>Cabors</th>
                                <th>Profil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelatih as $pelatih)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $pelatih->name }} {{ $pelatih->lastname }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pelatih->tgl_lahir)->format('d M Y') }}
                                    </td>
                                    <td>{{ $pelatih->no_telp }}</td>
                                    <td>{{ $pelatih->no_kk }}</td>
                                    <td>{{ $pelatih->no_ktp }}</td>
                                    <td class="text-capitalize">{{ $pelatih->address }}</td>
                                    <td>{{ $pelatih->email }}</td>
                                    <td>{{ $pelatih->club_name }}</td>
                                    <td>{{ $pelatih->cabang }}</td>
                                    <td>
                                        @if (!empty($pelatih->profile_pic))
                                            <img style="width: 50px; height: auto;" class="img-thumbnail text-center"
                                                src="{{ asset('uploads/' . $pelatih->profile_pic) }}" alt="Image News" />
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dapatkan elemen-elemen tombol dan tabel
        const btnAtlet = document.getElementById('btnAtlet');
        const btnTeam = document.getElementById('btnTeam');
        const btnPelatih = document.getElementById('btnPelatih');
        const tableAtlet = document.getElementById('tableAtlet');
        const tableTeam = document.getElementById('tableTeam');
        const tablePelatih = document.getElementById('tablePelatih');

        // Sembunyikan semua tabel saat halaman pertama kali dimuat
        tableAtlet.style.display = 'table';
        tableTeam.style.display = 'none';
        tablePelatih.style.display = 'none';

        // Tambahkan event listener pada tombol-tombol untuk mengatur tampilan tabel
        btnAtlet.addEventListener('click', function() {
            tableAtlet.style.display = 'table';
            tableTeam.style.display = 'none';
            tablePelatih.style.display = 'none';
        });

        btnTeam.addEventListener('click', function() {
            tableAtlet.style.display = 'none';
            tableTeam.style.display = 'table';
            tablePelatih.style.display = 'none';
        });

        btnPelatih.addEventListener('click', function() {
            tableAtlet.style.display = 'none';
            tableTeam.style.display = 'none';
            tablePelatih.style.display = 'table';
        });
    </script>
@endsection
