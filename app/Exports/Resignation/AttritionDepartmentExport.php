<?php
 
namespace App\Exports\Resignation;
 
use App\Model\Departement;
use App\Model\GradeGroup;
use App\Model\Plugin\PluginPeriod;
use App\Model\Resignation\Resign;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
 
class AttritionDepartmentExport implements FromArray, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithTitle
{
    private $type;
    private $month;
    private $quarter;
    private $year;
    private $period;

    public function __construct($type, $month, $quarter, $year, $period)
    {
        $this->type = $type;
        $this->month = $month;
        $this->quarter = $quarter;
        $this->year = $year;
        $this->period = $period;
    }

    public function title(): string
    {
        return 'Attrition Rate Department';
    }

    public function headings(): array
    {
    	$head = '';
        if($this->type == 1) { // MONTHLY
            $date = date_create($this->year.'-'.$this->month.'-01');
            $head = date_format($date, 'F Y');
        } else if($this->type == 2) { // QUARTERLY
            $head = $this->quarter.' '.$this->year;
        } else if($this->type == 3) { // PERIODICALLY
            $head = PluginPeriod::where('period_id', $this->period)->first()->period_name;
        }

        $dept = Departement::pluck('department_name')->toArray();

        $headings = [
            [
                'NO',
                'LEVEL',
                $head
            ],
            [
                '', ''
            ]
        ];

        foreach($dept as $d) {
            array_push($headings[1], $d);
        }

        return $headings;
    }

    public function map($data): array
    {
        $map = [
            $data->grade_group_id,
            $data->grade_group_name
        ];

        $department = Departement::pluck('department_id');

        foreach($department as $key => $val) {
            array_push($map, $data->$val);
        }

        return $map;
    }

    public function array(): array
    {
        $data = array();

        $grade_group = GradeGroup::orderBy('grade_group_id', 'DESC')->get();
        $department = Departement::pluck('department_id');

        foreach($grade_group as $gg) {
            $object = (object) array();
            $object->grade_group_id = $gg->grade_group_id;
            $object->grade_group_name = $gg->grade_group_name;

            foreach($department as $key => $val) {
                $object->$val = Resign::query()
                    ->selectRaw('FORMAT(COUNT(mst_resignation_resign_list.resign_id), 0) AS count_resign')
                    ->leftJoin('mst_main_user AS u', 'u.user_nik', 'mst_resignation_resign_list.user_nik')
                    ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'u.grade_id')
                    ->where('mst_resignation_resign_list.resign_clearance_status', 'approve')
                    ->where('mst_resignation_resign_list.resign_status', 'approve')
                    ->where('ug.grade_group_id', $gg->grade_group_id)
                    ->where('u.department_id', $val);

                if($this->type == 1) { // MONTHLY
                    if($this->month != NULL && $this->year != NULL) {
                        $object->$val = $object->$val->whereMonth('mst_resignation_resign_list.resign_date', $this->month)->whereYear('mst_resignation_resign_list.resign_date', $this->year);
                    }
                } else if($this->type == 2) { // QUARTEmst_resignation_resign_listY
                    if($this->quarter != NULL && $this->year != NULL) {
                        if($this->quarter == 'Q1') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 04')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 05')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 06');
                            })->whereYear('mst_resignation_resign_list.resign_date', $this->year);
                        } else if($this->quarter == 'Q2') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 07')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 08')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 09');
                            })->whereYear('mst_resignation_resign_list.resign_date', $this->year);
                        } else if($this->quarter == 'Q3') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 10')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 11')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 12');
                            })->whereYear('mst_resignation_resign_list.resign_date', $this->year);
                        } else if($this->quarter == 'Q4') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 01')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 02')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 03');
                            })->whereYear('mst_resignation_resign_list.resign_date', $this->year);
                        }
                    }
                } else if($this->type == 3) { // PERIODICALLY
                    if($this->period > 0) {
                        $object->$val = $object->$val->where('mst_resignation_resign_list.period_id', $this->period);
                    }
                }

                $object->$val = $object->$val->first()->count_resign;
            }

            array_push($data, $object);
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(25);

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.'2')
                    ->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'E3E3E3',
                            ],
                        ],
                    ]);

                // $event->sheet->getDelegate()->setAutoFilter('A2:'.$highestColumn.'2');

                $event->sheet->getDelegate()->mergeCells('A1:A2');
                $event->sheet->getDelegate()->mergeCells('B1:B2');
                $event->sheet->getDelegate()->mergeCells('C1:J1');

                $event->sheet->getDelegate()->getStyle('A3:A'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('C3:J'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.$highestRow)->getBorders()->getAllBorders()
                    ->applyFromArray([
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ]);

                for($i=2; $i<$highestRow; $i++) {
                    $event->sheet->getDelegate()->getCell('A'.($i+1))->setValue($i-1);
                }

                $highestColumn++;
                $event->sheet->getDelegate()->freezePane('A3');
            },
        ];
    }
}