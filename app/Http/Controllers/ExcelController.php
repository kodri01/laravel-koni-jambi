<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{

    public function exportAtlet()
    {
        $data = [];
        $data[] = [
            'No',
            'Nama Depan',
            'Nama Belakang',
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
            ->get();

        foreach ($atletCollection as $index => $atlet) {
            $tglLahir = Carbon::parse($atlet->tgl_lahir)->format('d M Y');
            $data[] = [
                $index + 1, // Menambahkan nomor urut pada setiap baris
                $atlet->name,
                $atlet->lastname,
                $tglLahir,
                $atlet->no_telp,
                $atlet->no_kk,
                $atlet->no_ktp,
                $atlet->address,
                $atlet->email,
                $atlet->cabang,
            ];
        }

        $dateTime = date('Ymd_His');
        $fileName = 'data_atlet_' . $dateTime . '.xlsx';

        return Excel::download(new \App\Exports\AtletExport($data), $fileName);
    }

    public function exportTeam()
    {
        $data = [];
        $data[] = [
            'No',
            'Nama Klub',
            'Nama Team',
            'Slogan Team',
            'Team Leader',
            'Cabang Olahraga',
        ];
        $teamCollection = DB::table('teams')
            ->join('clubs', 'teams.club_id', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', 'cabors.id')
            ->join('users', 'teams.leader_team', '=',  'users.id')
            ->select(
                'clubs.club_name',
                'teams.team_name',
                'teams.slogan',
                'users.name as leader_team',
                'cabors.name as cabang',
            )
            ->whereNull('teams.deleted_at')
            ->get();
        foreach ($teamCollection as $index => $team) {
            $data[] = [
                $index + 1, // Menambahkan nomor urut pada setiap baris
                $team->club_name,
                $team->team_name,
                $team->slogan,
                $team->leader_team,
                $team->cabang,
            ];
        }

        $dateTime = date('Ymd_His');
        $fileName = 'data_team_' . $dateTime . '.xlsx';

        return Excel::download(new \App\Exports\TeamExport($data), $fileName);
    }

    public function exportPelatih()
    {
        $data = [];
        $data[] = [
            'No',
            'Nama Depan',
            'Nama Belakang',
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
            ->get();

        foreach ($pelatihCollection as $index => $pelatih) {
            $tglLahir = Carbon::parse($pelatih->tgl_lahir)->format('d M Y');

            $data[] = [
                $index + 1, // Menambahkan nomor urut pada setiap baris
                $pelatih->name,
                $pelatih->lastname,
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
