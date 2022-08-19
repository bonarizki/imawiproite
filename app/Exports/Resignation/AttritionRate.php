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

class AttritionRate implements WithHeadings,WithStyles,WithEvents,ShouldAutoSize,WithColumnFormatting,FromArray,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $ReportInterfaces;
    private $request;

    public function __construct($ReportInterfaces,$request)
    {
        $this->ReportInterfaces = $ReportInterfaces;
        $this->request = $request;
    }

    public function headings(): array
    {
         return [
            [
                'Level',
                $this->Header(),
                '',
                $this->Header2(),
            ],
            [
                '',
                'Nos',
                'Annualized %',
                ''
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
            'A3:A15' => ['font' => ['bold' => true]],
            'C' => []
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:A2');
                $event->sheet->getDelegate()->mergeCells('B1:C1');
                $event->sheet->getDelegate()->mergeCells('D1:D2');
                $event->sheet->getStyle('A1:D10')->applyFromArray([
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
            // 'C' => NumberFormat::FORMAT_PERCENTAGE,
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function monthNumber($month)
    {
        return date('m', strtotime($month));
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

    public function Header2()
    {
        if($this->request->type=='period'):
            return 'Total HC - '.$this->request->period_name;
        elseif ($this->request->type=='month') :
            return 'Total HC '.$this->request->month_name.'-'.$this->request->year_name; 
        elseif ($this->request->type=='quarter') :
            return 'Total HC '.$this->request->quarter_name.' '.$this->request->period_name;
        endif;
    }

    public function array(): array
    {
        $data = $this->ReportInterfaces->AtritionRate($this->request);
        $array = [];
        foreach ($data as $item ) {
            $array[] = [
                $item->grade_group_name => $item->grade_group_name,
                $item->total_resign => $item->total_resign,
                'annualised' => $this->annualised($item->total_resign,$item->total_hc),
                $item->total_hc => $item->total_hc,
            ];
        }
        return $array;
    }

    public function annualised($total_resign,$total_hc)
    {
        if($this->request->type == 'period'):
            return round($total_resign*(12/12)/$total_hc*100,2);
        elseif($this->request->type == 'month') :
            $month_sequence = $this->monthSequence($this->request->month_name);
            return round($total_resign*(12/$month_sequence)/$total_hc*100,2);
        endif;

    }

    public function monthSequence($month_name)
    {
        if($month_name == 'JANUARY'){
            $sequence = '10';
        }else if($month_name == 'FEBUARY') {
            $sequence = '11';
        }else if($month_name == 'MARCH') {
            $sequence = '12';
        }else if($month_name == 'APRIL') {
            $sequence = '1';
        }else if($month_name == 'MAY') {
            $sequence = '2';
        }else if($month_name == 'JUNE') {
            $sequence = '3';
        }else if($month_name == 'JULY') {
            $sequence = '4';
        }else if($month_name == 'AUGUST') {
            $sequence = '5';
        }else if($month_name == 'SEPTEMBER') {
            $sequence = '6';
        }else if($month_name == 'OCTOBER') {
            $sequence = '7';
        }else if($month_name == 'NOVEMBER') {
            $sequence = '8';
        }else if($month_name == 'DECEMBER') {
            $sequence = '9';
        }

        return $sequence;
    }
}
