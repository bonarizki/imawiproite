<?php

namespace App\Exports\Resignation;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AttritionRateInitiation implements WithHeadings,WithStyles,WithEvents,ShouldAutoSize,WithColumnFormatting,FromArray,WithStrictNullComparison
{
    private $request;
    private $ReportInterfaces;

    public function __construct($ReportInterfaces,$request)
    {
        $this->request = $request;
        $this->ReportInterfaces = $ReportInterfaces;
    }

    public function headings(): array
    {
        //paramater yg dikirim berdasarkan id dari tabel mst_main_grade_group
        //not parameter akan digunakan untuk menyatakan not in
        return [
            [
                'level',
                $this->Header(),
            ],
            [
                '',
                'Vol',
                'Non - Vol'
            ]
        ];
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
            2    => ['font' => ['bold' => true]],
            // Styling a specific cell by coordinate.
            'A3:A10' => ['font' => ['bold' => true]],
            'C' => []
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:A2');
                $event->sheet->getDelegate()->mergeCells('B1:C1');
                $event->sheet->getStyle('A1:C10')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function Header()
    {
        if($this->request->type=='period'):
            return 'FY - '.$this->request->period_name;
        elseif ($this->request->type=='month') :
            return $this->request->month_name.'-'.$this->request->year_name; 
        elseif ($this->request->type=='quarter') :
            return $this->request->quarter_name.' '.$this->request->period_name;
        endif;
    }

    public function array(): array
    {
        return $this->ReportInterfaces->ARInitiation($this->request);
    }
}
