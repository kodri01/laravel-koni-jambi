<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;


class TeamExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithDrawings, WithCustomStartCell, WithTitle
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

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('images/logo.png'));
        $drawing->setCoordinates('C1');
        $drawing->setWidth(75);
        $drawing->setHeight(75);

        return [$drawing];
    }

    public function title(): string
    {
        return 'Laporan Team';
    }

    public function startCell(): string
    {
        return 'A2'; // Mulai dari sel A5
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cell dari A1 sampai I1
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A7:G7');
                $event->sheet->mergeCells('A8:G8');

                // Mengatur font size, tipe bold, dan alignment center untuk kalimat "Laporan Data Atlet KONI Provinsi Jambi Tahun 2023"
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'bold' => false,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('C5:F5')->applyFromArray([
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);


                // Mengatur tinggi baris agar garis berdempetan
                $event->sheet->getRowDimension(5)->setRowHeight(3);
                $event->sheet->getRowDimension(6)->setRowHeight(7);

                $event->sheet->getStyle('A7:G7')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A8:G8')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A10:G10')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);

                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $range = 'A10:' . $highestColumn . $highestRow;
                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Menambahkan informasi penanggung jawab
                $penanggungJawab = "Jambi, " . date('d F Y') . "\nKetua Umum\n\n\n\nBudi Setiawan,S.P.,M.M.";
                $event->sheet->setCellValue('G' . ($event->sheet->getHighestRow() + 3), $penanggungJawab);
                $event->sheet->getStyle('G' . ($event->sheet->getHighestRow()))->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('G' . ($event->sheet->getHighestRow()))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getRowDimension($event->sheet->getHighestRow())->setRowHeight(86);
            },
        ];
    }
}
