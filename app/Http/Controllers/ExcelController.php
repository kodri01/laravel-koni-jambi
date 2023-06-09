<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export()
    {
        $users = User::all(); // Ganti dengan model dan query yang sesuai

        $data = [];
        $data[] = ['No', 'Nama', 'Email']; // Header kolom

        foreach ($users as $index => $user) {
            $data[] = [$index + 1, $user->name, $user->email]; // Data yang akan diekspor
        }

        $fileName = 'data_eksport_' . date('Ymd_His') . '.xlsx';

        return Excel::download(function ($excel) use ($data) {
            $excel->setTitle('Users');
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, false);
            });
        }, $fileName);
    }

    // public function import()
    // {
    //     $path = public_path('path/to/excel/file.xlsx');

    //     $data = Excel::load($path)->get();

    //     // Proses data yang diimpor
    // }
}
