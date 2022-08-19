<?php

namespace App\Exports\Koperasi;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderList implements WithHeadings,ShouldAutoSize,FromArray,WithStyles,WithEvents
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:H'.$highestRow)->applyFromArray([
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

    public function headings():array
    {
        return [
            "No PO",
            "Order Request",
            "Order Date",
            "Brand",
            "Product Category",
            "Product Code",
            "Product Name",
            "QTY",
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $header) {
                foreach ($header->Detail as $item) {
                    $array[] = [
                        $header->order_header_id,
                        $header->User->user_name,
                        explode(' ', $header->created_at)[0],
                        $item->Product->brand_name,
                        $item->Product->category_name,
                        $item->Product->product_code,
                        $item->Product->product_name,
                        $item->qty,
                    ];
                }
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }

}
