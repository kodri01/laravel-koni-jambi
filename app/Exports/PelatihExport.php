<?php

namespace App\Exports;

use App\Models\Pelatih;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelatihExport implements FromCollection, WithHeadings
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
}
