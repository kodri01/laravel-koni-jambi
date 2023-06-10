<?php

namespace App\Exports;

use App\Models\TeamModel; // Ganti dengan model yang sesuai
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeamExport implements FromCollection, WithHeadings
{
    // public function collection()
    // {
    //     $teamCollection = DB::table('teams')
    //         ->join('clubs', 'teams.club_id', 'clubs.id')
    //         ->join('cabors', 'clubs.cabang_id', 'cabors.id')
    //         ->join('users', 'teams.leader_team', '=',  'users.id')
    //         ->select(
    //             'clubs.club_name',
    //             'teams.team_name',
    //             'users.name as leader_team',
    //             'users.name as anggota_team',
    //             'cabors.name as cabang',
    //         )
    //         ->whereNull('teams.deleted_at')
    //         ->get();
    //     return $teamCollection;
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Nama Klub',
    //         'Nama Team',
    //         'Team Leader',
    //         'Anggota',
    //         'Cabang Olahraga',
    //     ];
    // }

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect(array_slice($this->data, 1)); // Menghilangkan baris judul
    }

    public function headings(): array
    {
        return $this->data[0];
    }
}
