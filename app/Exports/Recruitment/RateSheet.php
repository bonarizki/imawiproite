<?php
 
namespace App\Exports\Recruitment;
 
use App\Model\Departement;
use App\Model\GradeGroup;
use App\Model\Recruitment\Recruit;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
 
class RateSheet implements FromArray, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithTitle
{
    private $sheet;
    private $period;
    private $grade_group;
    private $department;

    public function __construct($sheet, $period, $grade_group, $department)
    {
        $this->sheet = $sheet;
        $this->period = $period;
        $this->grade_group = $grade_group;
        $this->department = $department;
    }

    public function title(): string
    {
        $title = '';

        if($this->sheet == 'gg') {
            $title = 'Fulfillment Rate By Grade Group';
        } else if($this->sheet == 'dept') {
            $title = 'Fulfillment Rate By Department';
        }

        return $title;
    }

    public function headings(): array
    {
    	$headings = array();

        if($this->sheet == 'gg') {
            $headings = [
                'NO',
                'GRADE GROUP',
                'TOTAL REQUEST',
                'TOTAL FULFILLED',
                'AVERAGE LEAD TIME',
                'AVERAGE COST/HIRE'
            ];
        } else if($this->sheet == 'dept') {
            $headings = [
                'NO',
                'DEPARTMENT',
                'TOTAL REQUEST',
                'TOTAL FULFILLED',
                'AVERAGE LEAD TIME',
                'AVERAGE COST/HIRE'
            ];
        }

        return $headings;
    }

    public function map($r): array
    {
        $map = array();

        if($this->sheet == 'gg') {
            $map = [
                $r->grade_group_id,
                $r->grade_group_name,
                $r->request,
                $r->fulfilled,
                $r->lead_time,
                $r->cost_hire
            ];
        } else if($this->sheet == 'dept') {
            $map = [
                $r->department_id,
                $r->department_name,
                $r->request,
                $r->fulfilled,
                $r->lead_time,
                $r->cost_hire
            ];
        }

        return $map;
    }

    public function array(): array
    {
        $data = array();

        if($this->sheet == 'gg') {
            $grade_group_all = GradeGroup::get();

            foreach($grade_group_all as $gg) {
                $object = (object) array();
                $object->grade_group_id = $gg->grade_group_id;
                $object->grade_group_name = $gg->grade_group_name;

                $object->request = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id);

                $object->fulfilled = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                $object->lead_time = Recruit::query()
                    ->selectRaw('IFNULL(FORMAT(AVG(DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start)), 2), 0) AS lead_time')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                $object->cost_hire = Recruit::query()
                    ->selectRaw('IFNULL(FORMAT(AVG(trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus), 0), 0) AS cost_hire')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                if($this->department > 0) {
                    $object->request = $object->request->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->lead_time = $object->lead_time->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->cost_hire = $object->cost_hire->where('trans_recruitment_recruit.department_id', $this->department);
                }

                if($this->period > 0) {
                    $object->request = $object->request->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->lead_time = $object->lead_time->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->cost_hire = $object->cost_hire->where('trans_recruitment_recruit.period_id', $this->period);
                }

                $object->request = $object->request->first()->count_request;
                $object->fulfilled = $object->fulfilled->first()->count_request;
                $object->lead_time = $object->lead_time->first()->lead_time;
                $object->cost_hire = $object->cost_hire->first()->cost_hire;

                array_push($data, $object);
            }
        } else if($this->sheet == 'dept') {
            $department_all = Departement::get();

            foreach($department_all as $d) {
                $object = (object) array();
                $object->department_id = $d->department_id;
                $object->department_name = $d->department_name;

                $object->request = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id);

                $object->fulfilled = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                $object->lead_time = Recruit::query()
                    ->selectRaw('IFNULL(FORMAT(AVG(DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start)), 2), 0) AS lead_time')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                $object->cost_hire = Recruit::query()
                    ->selectRaw('IFNULL(FORMAT(AVG(trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus), 0), 0) AS cost_hire')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                if($this->grade_group > 0) {
                    $object->request = $object->request->where('g.grade_group_id', $this->grade_group);
                    $object->fulfilled = $object->fulfilled->where('g.grade_group_id', $this->grade_group);
                    $object->lead_time = $object->lead_time->where('g.grade_group_id', $this->grade_group);
                    $object->cost_hire = $object->cost_hire->where('g.grade_group_id', $this->grade_group);
                }

                if($this->period > 0) {
                    $object->request = $object->request->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->lead_time = $object->lead_time->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->cost_hire = $object->cost_hire->where('trans_recruitment_recruit.period_id', $this->period);
                }

                $object->request = $object->request->first()->count_request;
                $object->fulfilled = $object->fulfilled->first()->count_request;
                $object->lead_time = $object->lead_time->first()->lead_time;
                $object->cost_hire = $object->cost_hire->first()->cost_hire;

                array_push($data, $object);
            }
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

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.'1')
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

                $event->sheet->getDelegate()->setAutoFilter('A1:'.$highestColumn.'1');

                $event->sheet->getDelegate()->getStyle('A2:A'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('C2:F'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.$highestRow)->getBorders()->getAllBorders()
                    ->applyFromArray([
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ]);

                for($i=1; $i<$highestRow; $i++) {
                    $event->sheet->getDelegate()->getCell('A'.($i+1))->setValue($i);
                }

                $highestColumn++;
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }
}