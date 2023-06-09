<?php

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel extends Controller
{
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'data koni.xlsx');
    }
}
