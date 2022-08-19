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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;



class ReportByFeedback implements WithHeadings,ShouldAutoSize,WithStyles,WithEvents,WithStrictNullComparison,FromArray,WithColumnFormatting
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
            
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' =>NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:AC1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:AC'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('J1:J'.$highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
            },
        ];
    }

    public function headings():array
    {
        return [
            [
                "Bulan",
                "Tahun",
                "Topic Training",
                "Vendor Type",
                "Vendor",
                "Training Category",
                "Training Method",
                "Jumlah Hari",
                "Department",
                "NIK",
                "Participant Name",
                "Question 1",
                "Question 2",
                "Question 3",
                "Question 4",
                "Question 5",
                "Question 6",
                "Question 7",
                "Question 8",
                "Question 9",
                "Question 10",
                "Question 11",
                "Question 12",
                "Question 13",
                "Question 14",
                "Question 15",
                "Question 16",
                "Question 17",
                "Question 18",
            ]
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $item) {
                $array[]= [
                    date('F', mktime(0, 0, 0, $item->bulan, 10)),
                    $item->tahun,
                    $item->training_topic,
                    $item->vendor_type,
                    $item->vendor_name,
                    $item->category_name,
                    $item->method_name,
                    $item->training_total,
                    $item->department_name,
                    $item->training_user_nik,
                    $item->user_name,
                    $item->training_feedback_1,
                    $item->training_feedback_2,
                    $item->training_feedback_3,
                    $item->training_feedback_4,
                    $item->training_feedback_5,
                    $item->training_feedback_6,
                    $item->training_feedback_7,
                    $item->training_feedback_8,
                    $item->training_feedback_9,
                    $item->training_feedback_10,
                    $item->training_feedback_11,
                    $item->training_feedback_12,
                    $item->training_feedback_13,
                    $item->training_feedback_14,
                    $item->training_feedback_15,
                    $item->training_feedback_16,
                    $item->training_feedback_17,
                    $item->training_feedback_18,
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
