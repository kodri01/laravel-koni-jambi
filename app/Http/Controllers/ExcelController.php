<?php

namespace App\Http\Controllers;

use App\Exports\TeamExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{

    public function exportAtlet()
    {
        $data[] = [
            'KOMITE OLAHRAGA NASIONAL INDONESIA (KONI) PROVINSI JAMBI'
        ];
        $data[] = [
            'Jl. Halim Perdana Kusuma No.40, Sungai Asam, Kec. Ps. Jambi, Kota Jambi, Jambi 36123'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'LAPORAN ATLET CABANG OLAHRAGA KONI PROVINSI JAMBI'
        ];
        $data[] = [
            'TAHUN 2023'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'No',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Nomor Telepon',
            'Nomor KK',
            'Nomor KTP',
            'Alamat',
            'Email',
            'Cabang Olahraga',
        ];

        $atletCollection = DB::table('users')
            ->join('atlets', 'users.id', '=', 'atlets.iduser')
            ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.name',
                'users.lastname',
                'users.tgl_lahir',
                'users.no_telp',
                'users.no_kk',
                'users.no_ktp',
                'users.address',
                'users.email',
                'cabors.name as cabang'
            )
            ->where('users.active_atlet', 1)
            ->whereNull('atlets.deleted_at')
            ->orderBy('name', 'asc')
            ->get();

        foreach ($atletCollection as $index => $atlet) {
            $tglLahir = Carbon::parse($atlet->tgl_lahir)->format('d M Y');
            $atletFullName = $atlet->name . ' ' . $atlet->lastname;
            $data[] = [
                $index + 1, // Menambahkan nomor urut pada setiap baris
                $atletFullName,
                $tglLahir,
                $atlet->no_telp,
                $atlet->no_kk,
                $atlet->no_ktp,
                $atlet->address,
                $atlet->email,
                $atlet->cabang,
            ];
        }

        // array_unshift($data, ['Laporan Data Atlet KONI Provinsi Jambi Tahun 2023']);

        $dateTime = date('Ymd_His');
        $fileName = 'data_atlet_' . $dateTime . '.xlsx';

        return Excel::download(new \App\Exports\AtletExport($data), $fileName);
    }



    public function exportTeam()
    {
        $data[] = [
            'KOMITE OLAHRAGA NASIONAL INDONESIA (KONI) PROVINSI JAMBI'
        ];
        $data[] = [
            'Jl. Halim Perdana Kusuma No.40, Sungai Asam, Kec. Ps. Jambi, Kota Jambi, Jambi 36123'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'LAPORAN TEAM CABANG OLAHRAGA KONI PROVINSI JAMBI'
        ];
        $data[] = [
            'TAHUN 2023'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'No',
            'Nama Klub',
            'Nama Team',
            'Slogan Team',
            'Team Leader',
            'Anggota Team',
            'Cabang Olahraga',
        ];


        $teamCollection = DB::table('teams')
            ->join('clubs', 'teams.club_id', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', 'cabors.id')
            ->join('users', 'teams.leader_team', '=', 'users.id')
            ->select(
                'clubs.club_name',
                'teams.team_name',
                'teams.slogan',
                'users.name as leader_team',
                'users.lastname as leader_lastname',
                'cabors.name as cabang',
                'teams.atlet'
            )
            ->whereNull('teams.deleted_at')
            ->orderBy('team_name', 'asc')
            ->get();

        foreach ($teamCollection as $index => $team) {
            $atletIds = json_decode($team->atlet);
            $atletUsers = User::whereIn('id', $atletIds)->get();
            // $atletNames = $atletUsers->pluck('name')->implode(', ');
            $atletNames = $atletUsers->map(function ($user) {
                return $user->name . ' ' . $user->lastname;
            })->implode(', ');
            $leaderFullName = $team->leader_team . ' ' . $team->leader_lastname;

            $data[] = [
                $index + 1,
                $team->club_name,
                $team->team_name,
                $team->slogan,
                $leaderFullName,
                $atletNames,
                $team->cabang,
            ];
        }

        $dateTime = date('Ymd_His');
        $fileName = 'data_team_' . $dateTime . '.xlsx';

        return Excel::download(new \App\Exports\TeamExport($data), $fileName);
    }

    public function exportPelatih()
    {
        $data[] = [
            'KOMITE OLAHRAGA NASIONAL INDONESIA (KONI) PROVINSI JAMBI'
        ];
        $data[] = [
            'Jl. Halim Perdana Kusuma No.40, Sungai Asam, Kec. Ps. Jambi, Kota Jambi, Jambi 36123'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'LAPORAN PELATIH CABANG OLAHRAGA KONI PROVINSI JAMBI'
        ];
        $data[] = [
            'TAHUN 2023'
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'No',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Nomor Telepon',
            'Nomor KK',
            'Nomor KTP',
            'Alamat',
            'Email',
            'Cabang Olahraga',
        ];
        $pelatihCollection = DB::table('users')
            ->join('pelatih', 'users.id', '=', 'pelatih.user_id')
            ->join('clubs', 'pelatih.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.name',
                'users.lastname',
                'users.tgl_lahir',
                'users.no_telp',
                'users.no_kk',
                'users.no_ktp',
                'users.address',
                'users.email',
                'cabors.name as cabang'
            )
            ->where('users.active', 99)
            ->whereNull('pelatih.deleted_at')
            ->orderBy('name', 'asc')
            ->get();

        foreach ($pelatihCollection as $index => $pelatih) {
            $tglLahir = Carbon::parse($pelatih->tgl_lahir)->format('d M Y');
            $pelatihFullName = $pelatih->name . ' ' . $pelatih->lastname;

            $data[] = [
                $index + 1, // Menambahkan nomor urut pada setiap baris
                $pelatihFullName,
                $tglLahir,
                $pelatih->no_telp,
                $pelatih->no_kk,
                $pelatih->no_ktp,
                $pelatih->address,
                $pelatih->email,
                $pelatih->cabang,
            ];
        }

        $dateTime = date('Ymd_His');
        $fileName = 'data_pelatih_' . $dateTime . '.xlsx';

        return Excel::download(new \App\Exports\PelatihExport($data), $fileName);
    }
}
