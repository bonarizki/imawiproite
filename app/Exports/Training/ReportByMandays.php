<?php

namespace App\Exports\Training;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ReportByMandays implements WithHeadings,ShouldAutoSize,FromArray,WithStyles,WithEvents,WithStrictNullComparison
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal'=>'center',
                    'vertical'=>'center']
            ],
            2    => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal'=>'center',
                    'vertical'=>'center']
            ],
            3    => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal'=>'center',
                    'vertical'=>'center']
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:Q3')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:Q'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getDelegate()->mergeCells('A1:A3');
                $event->sheet->getDelegate()->mergeCells('B1:Q1');
                $event->sheet->getDelegate()->mergeCells('B2:E2');
                $event->sheet->getDelegate()->mergeCells('F2:I2');
                $event->sheet->getDelegate()->mergeCells('J2:M2');
                $event->sheet->getDelegate()->mergeCells('N2:Q2');
            },
        ];
    }

    public function headings():array
    {
        return [
            [
               "Grading",
               "Training Mandays",
            ],[
                "",
                "Q1",
                "",
                "",
                "",
                "Q2",
                "",
                "",
                "",
                "Q3",
                "",
                "",
                "",
                "Q4",
                "",
                "",
                "",
            ],[
                "",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "Jumlah Hari",
                "Mandays",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "Jumlah Hari",
                "Mandays",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "Jumlah Hari",
                "Mandays",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "Jumlah Hari",
                "Mandays",
            ]
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $item) {
                $array[]= [
                    $item->grade,
                    $item->total_karyawan_q1,
                    $item->total_participant_q1,
                    $item->total_hari_q1,
                    $item->total_mandays_q1,
                    $item->total_karyawan_q2,
                    $item->total_participant_q2,
                    $item->total_hari_q2,
                    $item->total_mandays_q2,
                    $item->total_karyawan_q3,
                    $item->total_participant_q3,
                    $item->total_hari_q3,
                    $item->total_mandays_q3,
                    $item->total_karyawan_q4,
                    $item->total_participant_q4,
                    $item->total_hari_q4,
                    $item->total_mandays_q4,
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
