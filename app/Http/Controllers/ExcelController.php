<?php

namespace App\Http\Controllers;

use App\Exports\TeamExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;



class ExcelController extends Controller
{

    public function exportAtlet(Request $request)
    {
        $tahunFilter = $request->input('tahun');

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
            ($tahunFilter ? 'TAHUN ' . $tahunFilter : 'SEMUA TAHUN')
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'No',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Nomor Telepon',
            'Tahun',
            'Nomor KTP',
            'Alamat',
            'Email',
            'Cabang Olahraga',
        ];

        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {
            $atletCollection = DB::table('users')
                ->join('atlets', 'users.id', '=', 'atlets.iduser')
                ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
                ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
                ->select(
                    'users.name',
                    'users.lastname',
                    'users.tgl_lahir',
                    'users.no_telp',
                    'users.no_ktp',
                    'users.address',
                    'users.email',
                    'cabors.name as cabang',
                    'atlets.created_at as tahun_atlet',
                )
                ->where('users.active_atlet', 1)
                ->whereNull('atlets.deleted_at')
                ->when($tahunFilter, function ($query) use ($tahunFilter) {
                    return $query->whereYear('atlets.created_at', $tahunFilter);
                })
                ->orderBy('name', 'asc')
                ->get();

            foreach ($atletCollection as $index => $atlet) {
                $tglLahir = Carbon::parse($atlet->tgl_lahir)->format('d M Y');
                $tahun = Carbon::parse($atlet->tahun_atlet)->format('Y');
                $atletFullName = $atlet->name . ' ' . $atlet->lastname;
                $data[] = [
                    $index + 1, // Menambahkan nomor urut pada setiap baris
                    $atletFullName,
                    $tglLahir,
                    $atlet->no_telp,
                    $tahun,
                    $atlet->no_ktp,
                    $atlet->address,
                    $atlet->email,
                    $atlet->cabang,
                ];
            }

            $dateTime = date('Ymd_His');
            $fileName = 'data_atlet_' . $dateTime . '.xlsx';

            return Excel::download(new \App\Exports\AtletExport($data), $fileName);
        } else {
            $atletCollection = DB::table('users')
                ->join('atlets', 'users.id', '=', 'atlets.iduser')
                ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
                ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
                ->select(
                    'users.name',
                    'users.lastname',
                    'users.tgl_lahir',
                    'users.no_telp',
                    'users.no_ktp',
                    'users.address',
                    'users.email',
                    'cabors.name as cabang',
                    'atlets.created_at as tahun_atlet',
                )
                ->where('users.active_atlet', 1)
                ->where('cabors.id', auth()->user()->cabang_id)
                ->whereNull('atlets.deleted_at')
                ->when($tahunFilter, function ($query) use ($tahunFilter) {
                    return $query->whereYear('atlets.created_at', $tahunFilter);
                })
                ->orderBy('name', 'asc')
                ->get();

            foreach ($atletCollection as $index => $atlet) {
                $tglLahir = Carbon::parse($atlet->tgl_lahir)->format('d M Y');
                $tahun = Carbon::parse($atlet->tahun_atlet)->format('Y');
                $atletFullName = $atlet->name . ' ' . $atlet->lastname;
                $data[] = [
                    $index + 1, // Menambahkan nomor urut pada setiap baris
                    $atletFullName,
                    $tglLahir,
                    $atlet->no_telp,
                    $tahun,
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

        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {
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
        } else {
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
                ->where('cabors.id', auth()->user()->cabang_id)
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
    }

    public function exportPelatih(Request $request)
    {
        $tahunFilter = $request->input('tahun');

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
            ($tahunFilter ? 'TAHUN ' . $tahunFilter : 'SEMUA TAHUN')
        ];
        $data[] = [
            ''
        ];
        $data[] = [
            'No',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Nomor Telepon',
            'Tahun',
            'Nomor KTP',
            'Alamat',
            'Email',
            'Cabang Olahraga',
        ];

        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {
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
                    'pelatih.created_at as tahun_pelatih',
                    'cabors.name as cabang'
                )
                ->where('users.active', 99)
                ->whereNull('pelatih.deleted_at')
                ->when($tahunFilter, function ($query) use ($tahunFilter) {
                    return $query->whereYear('pelatih.created_at', $tahunFilter);
                })
                ->orderBy('name', 'asc')
                ->get();

            foreach ($pelatihCollection as $index => $pelatih) {
                $tglLahir = Carbon::parse($pelatih->tgl_lahir)->format('d M Y');
                $tahun = Carbon::parse($pelatih->tahun_pelatih)->format('Y');
                $pelatihFullName = $pelatih->name . ' ' . $pelatih->lastname;

                $data[] = [
                    $index + 1, // Menambahkan nomor urut pada setiap baris
                    $pelatihFullName,
                    $tglLahir,
                    $pelatih->no_telp,
                    $tahun,
                    $pelatih->no_ktp,
                    $pelatih->address,
                    $pelatih->email,
                    $pelatih->cabang,
                ];
            }

            $dateTime = date('Ymd_His');
            $fileName = 'data_pelatih_' . $dateTime . '.xlsx';

            return Excel::download(new \App\Exports\PelatihExport($data), $fileName);
        } else {
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
                    'pelatih.created_at as tahun_pelatih',
                    'cabors.name as cabang'
                )
                ->where('users.active', 99)
                ->where('cabors.id', auth()->user()->cabang_id)
                ->whereNull('pelatih.deleted_at')
                ->when($tahunFilter, function ($query) use ($tahunFilter) {
                    return $query->whereYear('pelatih.created_at', $tahunFilter);
                })
                ->orderBy('name', 'asc')
                ->get();

            foreach ($pelatihCollection as $index => $pelatih) {
                $tglLahir = Carbon::parse($pelatih->tgl_lahir)->format('d M Y');
                $tahun = Carbon::parse($pelatih->tahun_pelatih)->format('Y');
                $pelatihFullName = $pelatih->name . ' ' . $pelatih->lastname;

                $data[] = [
                    $index + 1, // Menambahkan nomor urut pada setiap baris
                    $pelatihFullName,
                    $tglLahir,
                    $pelatih->no_telp,
                    $tahun,
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
}