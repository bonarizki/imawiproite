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

class ReportByExpanse implements WithHeadings,ShouldAutoSize,WithStyles,WithEvents,WithStrictNullComparison,FromArray
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
            ]

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:E2')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:E'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getDelegate()->mergeCells('A1:A2');
                $event->sheet->getDelegate()->mergeCells('B1:E1');
            },
        ];
    }

    public function headings():array
    {
        return [
            [
               "Departement",
               "Training Expense"
            ],[
                "",
                "Q1",
                "Q2",
                "Q3",
                "Q4"
            ]
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $item) {
                $array[]= [
                    $item->department_name,
                    "Rp. ". number_format($item->total_fee_q1,2,",","."),
                    "Rp. ". number_format($item->total_fee_q2,2,",","."),
                    "Rp. ". number_format($item->total_fee_q3,2,",","."),
                    "Rp. ". number_format($item->total_fee_q4,2,",","."),
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
