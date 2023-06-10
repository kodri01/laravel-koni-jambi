<?php

namespace App\Exports;

use App\Models\Atlet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AtletExport implements FromCollection, WithHeadings
{
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

    // public function collection()
    // {
    //     $atletCollection = DB::table('users')
    //         ->join('atlets', 'users.id', '=', 'atlets.iduser')
    //         ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
    //         ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
    //         ->select(
    //             'users.name',
    //             'users.lastname',
    //             'users.tanggal_lahir',
    //             'users.nomor_telepon',
    //             'users.nomor_kk',
    //             'users.no_ktp',
    //             'users.address',
    //             'users.email',
    //             'cabors.name as cabang'
    //         )
    //         ->where('users.active_atlet', 1)
    //         ->whereNull('atlets.deleted_at')
    //         ->get();

    //     return $atletCollection;
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Nama Depan',
    //         'Nama Belakang',
    //         'Tanggal Lahir',
    //         'Nomor Telepon',
    //         'Nomor KK',
    //         'Nomor KTP',
    //         'Alamat',
    //         'Email',
    //         'Cabang Olahraga',
    //     ];
    // }
}
