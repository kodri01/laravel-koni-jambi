@extends('master')
@section('title', '- Laporan')
@section('content')
    <div>
        <div class="bg-white rounded p-3 mb-3">
            <h2 class="color-title mt-1 mb-1">Laporan KONI</h2>
        </div>
        <div class="wrapper-table bg-white rounded ">
            <div class="w-100 ml-3">
                <div class="row my-2 pt-3">
                    <div class="col-sm-1">
                        <a href="#tableAtlet" id="btnAtlet" class="btn btn-primary">Data Atlet</a>
                    </div>
                    <div class="col-sm-1">
                        <a href="#tableTeam" id="btnTeam" class="btn btn-primary">Data Team</a>
                    </div>
                    <div class="col-sm-1 ml-1">
                        <a href="#tablePelatih" id="btnPelatih" class="btn btn-primary">Data Pelatih</a>
                    </div>

                </div>
            </div>

            <!-- Tabel Atlet -->
            <div id="tableAtlet" class="table-responsive-xxl container-fluid">
                <div class="row">
                    <div class="col">
                        <a id="exportAtletButton" href="{{ url('/export/atlet') }}?tahun=" class="btn btn-danger">Export to
                            <x-fileicon-microsoft-excel style="width: 20px; height:20px;" />
                        </a>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-sm">
                        <div class="input-group flex-nowrap w-50">
                            <span class="input-group-text" id="addon-wrapping"><b>Filter by Year:</b></span>
                            <select id="tahunAtlet" class="form-control">
                                <option value="">All</option>
                                @foreach ($tahunAtlet as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <form id="formAtlet" class="d-flex" method="GET" action="">
                            <div class="input-group">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <x-eos-person-search style="width: 20px; height:20px;" />
                                    </span>
                                </div>
                                <input id="searchInputAtlet" class="form-control me-2 mr-1" type="search" name="search"
                                    placeholder="Search Nama Atlet atau Cabang Olahraga" aria-label="Search">
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama lengkap</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor Telepon</th>
                            <th>Nomor KTP</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Tahun</th>
                            <th>Clubs</th>
                            <th>Cabors</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($atlet as $atlet)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $atlet->name }} {{ $atlet->lastname }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $atlet->tgl_lahir)->format('d F Y') }}
                                </td>
                                <td>{{ $atlet->no_telp }}</td>
                                <td>{{ $atlet->no_ktp }}</td>
                                <td class="text-capitalize">{{ $atlet->address }}</td>
                                <td>{{ $atlet->email }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $atlet->tahun)->format('Y') }}
                                </td>
                                <td>{{ $atlet->club_name }}</td>
                                <td>{{ $atlet->cabang }}</td>

                                <td><a href="{{ route('print.atlet', $atlet->id) }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <x-bx-printer style="width: 20px; height:20px;" />
                                    </a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p id="noDataMessageAtlet" style="display: none; text-align: center;">
                    <b>Nama Atlet Tidak Ditemukan</b>
                </p>
            </div>

            <!-- Tabel Team -->
            <div id="tableTeam" class="table-responsive-sm container-fluid">
                <a href="{{ url('/export/team') }}" class="btn btn-danger mb-2"> Export to
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
                                <td>{{ $team->leader_team }} {{ $team->leader_lastname }}</td>
                                <td>
                                    <ul>
                                        @foreach ($team->anggota_team as $anggota)
                                            <li>{{ $anggota->name }} {{ $anggota->lastname }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $team->cabang }}</td>
                                <td>
                                    @if (!empty($team->file_team))
                                        <img style="width: 50px; height: auto;" class="img-thumbnail text-center"
                                            src="{{ asset('uploads/' . $team->file_team) }}" alt="Image News" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Tabel Pelatih -->
            <div id="tablePelatih" class="table-responsive-xl container-fluid">
                <div class="row">
                    <div class="col">
                        <a id="exportPelatihButton" href="{{ url('/export/pelatih') }}?tahun=" class="btn btn-danger">
                            Export to
                            <x-fileicon-microsoft-excel style="width: 20px; height:20px;" />
                        </a>
                    </div>

                </div>
                <div class="row my-2">
                    <div class="col-sm">
                        <div class="input-group flex-nowrap w-50">
                            <span class="input-group-text " id="addon-wrapping"><b>Filter by Year:</b></span>
                            <select id="tahunPelatih" class="form-control">
                                <option value="">All</option>
                                @foreach ($tahunPelatih as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <form class="d-flex " method="GET" action="#">
                            <div class="input-group">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <x-eos-person-search style="width: 20px; height:20px;" />
                                    </span>
                                </div>
                                <input id="searchInputPelatih" class="form-control me-2 mr-1" type="search"
                                    placeholder="Search Nama Pelatih atau Cabang Olahraga" name="search_pelatih"
                                    aria-label="Search">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive-xxl">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama lengkap</th>
                                <th>Tanggal Lahir</th>
                                <th>Nomor Telepon</th>
                                <th>Nomor KTP</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Tahun</th>
                                <th>Clubs</th>
                                <th>Cabors</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelatih as $pelatih)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $pelatih->name }} {{ $pelatih->lastname }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pelatih->tgl_lahir)->format('d F Y') }}
                                    </td>
                                    <td>{{ $pelatih->no_telp }}</td>
                                    <td>{{ $pelatih->no_ktp }}</td>
                                    <td class="text-capitalize">{{ $pelatih->address }}</td>
                                    <td>{{ $pelatih->email }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pelatih->tahun)->format('Y') }}
                                    <td>{{ $pelatih->club_name }}</td>
                                    <td>{{ $pelatih->cabang }}</td>
                                    <td><a href="{{ route('print.pelatih', $pelatih->id) }}"
                                            class="btn btn-sm btn-primary" target="_blank">
                                            <x-bx-printer style="width: 20px; height:20px;" />
                                        </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p id="noDataMessagePelatih" style="display: none; text-align: center;"><b>Nama Pelatih Tidak
                            Ditemukan</b></p>
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
        const searchInputAtlet = document.getElementById('searchInputAtlet');
        const searchInputPelatih = document.getElementById('searchInputPelatih');
        const tahunAtlet = document.getElementById('tahunAtlet');

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

        // Tambahkan event listener pada input pencarian atlet
        searchInputAtlet.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const atletRows = tableAtlet.querySelectorAll('tbody tr');

            let isDataFound = false; // Tambahkan variabel isDataFound

            atletRows.forEach(function(row) {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const lastname = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const cabors = row.querySelector('td:nth-child(10)').textContent.toLowerCase();

                if (name.includes(searchValue) || lastname.includes(searchValue) || cabors.includes(
                        searchValue)) {
                    row.style.display = 'table-row';
                    isDataFound = true; // Set isDataFound menjadi true jika ada data yang cocok
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada data yang cocok
            const noDataMessage = document.getElementById('noDataMessageAtlet');
            if (isDataFound) {
                noDataMessage.style.display = 'none';
            } else {
                noDataMessage.style.display = 'block';
            }
        });

        // Tambahkan event listener pada input pencarian pelatih
        searchInputPelatih.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const pelatihRows = tablePelatih.querySelectorAll('tbody tr');

            let isDataFound = false; // Tambahkan variabel isDataFound

            pelatihRows.forEach(function(row) {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const lastname = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const cabors = row.querySelector('td:nth-child(10)').textContent.toLowerCase();


                if (name.includes(searchValue) || lastname.includes(searchValue) || cabors.includes(
                        searchValue)) {
                    row.style.display = 'table-row';
                    isDataFound = true; // Set isDataFound menjadi true jika ada data yang cocok
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada data yang cocok
            const noDataMessage = document.getElementById('noDataMessagePelatih');
            if (isDataFound) {
                noDataMessage.style.display = 'none';
            } else {
                noDataMessage.style.display = 'block';
            }
        });
    </script>

    <script>
        // Fungsi untuk melakukan filtering pada tabel atlet
        function filterDataAtletByYear() {
            var selectedYear = document.getElementById("tahunAtlet").value;
            var tableRows = document.getElementById("tableAtlet").getElementsByTagName("tbody")[0].getElementsByTagName(
                "tr");

            // Menampilkan semua baris
            for (var i = 0; i < tableRows.length; i++) {
                tableRows[i].style.display = "";
            }

            // Jika tahun yang dipilih tidak kosong, terapkan filter
            if (selectedYear !== "") {
                // Mengubah display property berdasarkan tahun yang dipilih
                for (var i = 0; i < tableRows.length; i++) {
                    var rowYear = tableRows[i].getElementsByTagName("td")[7].innerText;

                    if (rowYear !== selectedYear) {
                        tableRows[i].style.display = "none";
                    }
                }
            }

            // Menampilkan pesan jika tidak ada data yang sesuai dengan filter
            var noDataMessage = document.getElementById("noDataMessageAtlet");
            var visibleRows = document.querySelectorAll("#tableAtlet tbody tr[style='display: table-row;']");

            if (selectedYear !== "" && visibleRows.length === 0) {
                noDataMessage.style.display = "none";
            } else {
                noDataMessage.style.display = "none";
            }
        }

        // Event listener untuk memanggil fungsi filterDataAtletByYear() saat memilih opsi tahun pada tabel atlet
        document.getElementById("tahunAtlet").addEventListener("change", filterDataAtletByYear);
        document.getElementById("tahunAtlet").addEventListener("change", function() {
            var selectedYear = this.value;
            var exportButton = document.getElementById("exportAtletButton");
            var url = "{{ url('/export/atlet') }}?tahun=" + selectedYear;
            exportButton.setAttribute("href", url);
        });


        // Fungsi untuk melakukan filtering pada tabel pelatih
        function filterDataPelatihByYear() {
            var selectedYear = document.getElementById("tahunPelatih").value;
            var tableRows = document.getElementById("tablePelatih").getElementsByTagName("tbody")[0].getElementsByTagName(
                "tr");

            // Menampilkan semua baris
            for (var i = 0; i < tableRows.length; i++) {
                tableRows[i].style.display = "";
            }

            // Jika tahun yang dipilih tidak kosong, terapkan filter
            if (selectedYear !== "") {
                // Mengubah display property berdasarkan tahun yang dipilih
                for (var i = 0; i < tableRows.length; i++) {
                    var rowYear = tableRows[i].getElementsByTagName("td")[7].innerText;

                    if (rowYear !== selectedYear) {
                        tableRows[i].style.display = "none";
                    }
                }
            }

            // Menampilkan pesan jika tidak ada data yang sesuai dengan filter
            var noDataMessage = document.getElementById("noDataMessagePelatih");
            var visibleRows = document.querySelectorAll("#tablePelatih tbody tr[style='display: table-row;']");

            if (selectedYear !== "" && visibleRows.length === 0) {
                noDataMessage.style.display = "none";
            } else {
                noDataMessage.style.display = "none";
            }
        }

        // Event listener untuk memanggil fungsi filterDataPelatihByYear() saat memilih opsi tahun pada tabel pelatih
        document.getElementById("tahunPelatih").addEventListener("change", filterDataPelatihByYear);
        document.getElementById("tahunPelatih").addEventListener("change", function() {
            var selectedYear = this.value;
            var exportButton = document.getElementById("exportPelatihButton");
            var url = "{{ url('/export/pelatih') }}?tahun=" + selectedYear;
            exportButton.setAttribute("href", url);
        });
    </script>
@endsection
