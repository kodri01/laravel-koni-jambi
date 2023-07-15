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

class PelatihExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithDrawings, WithCustomStartCell, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect(array_slice($this->data, 1));
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
        return 'Laporan Pelatih';
    }

    public function startCell(): string
    {
        return 'A2'; // Mulai dari sel A2
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cell 
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');
                $event->sheet->mergeCells('A7:I7');
                $event->sheet->mergeCells('A8:I8');

                // Mengatur font size, tipe bold, dan alignment center
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

                $event->sheet->getStyle('C5:H5')->applyFromArray([
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

                $event->sheet->getRowDimension(5)->setRowHeight(3);
                $event->sheet->getRowDimension(6)->setRowHeight(7);

                $event->sheet->getStyle('A7:I7')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A8:I8')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A10:I10')->applyFromArray([
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
                $event->sheet->setCellValue('I' . ($event->sheet->getHighestRow() + 3), $penanggungJawab);
                $event->sheet->getStyle('I' . ($event->sheet->getHighestRow()))->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('I' . ($event->sheet->getHighestRow()))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getRowDimension($event->sheet->getHighestRow())->setRowHeight(86);
            },
        ];
    }
}
