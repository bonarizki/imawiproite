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
 
class ResourceSheet implements FromArray, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithTitle
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
            $title = 'Hiring Resource By Grade Group';
        } else if($this->sheet == 'dept') {
            $title = 'Hiring Resource By Department';
        }

        return $title;
    }

    public function headings(): array
    {
    	$headings = array();

        if($this->sheet == 'gg') {
            $headings = [
                [
                    'NO',
                    'GRADE GROUP',
                    'TOTAL FULFILLED REQUEST',
                    'HIRING RESOURCE'
                ],
                [
                    '', '', '',
                    'HEAD HUNTER',
                    'JOB FAIR',
                    'JOB ADS',
                    'LINKEDIN',
                    'OUTSOURCING',
                    'REFERENCE'
                ]
            ];
        } else if($this->sheet == 'dept') {
            $headings = [
                [
                    'NO',
                    'DEPARTMENT',
                    'TOTAL FULFILLED REQUEST',
                    'HIRING RESOURCE'
                ],
                [
                    '', '', '',
                    'HEAD HUNTER',
                    'JOB FAIR',
                    'JOB ADS',
                    'LINKEDIN',
                    'OUTSOURCING',
                    'REFERENCE'
                ]
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
                $r->fulfilled,
                $r->head_hunter,
                $r->job_fair,
                $r->job_ads,
                $r->linkedin,
                $r->outsourcing,
                $r->reference
            ];
        } else if($this->sheet == 'dept') {
            $map = [
                $r->department_id,
                $r->department_name,
                $r->fulfilled,
                $r->head_hunter,
                $r->job_fair,
                $r->job_ads,
                $r->linkedin,
                $r->outsourcing,
                $r->reference
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

                $object->fulfilled = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                $object->head_hunter = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Head Hunter');

                $object->job_fair = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Job Fair');

                $object->job_ads = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Job Ads');

                $object->linkedin = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'LinkedIn');

                $object->outsourcing = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Outsourcing');

                $object->reference = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('g.grade_group_id', $gg->grade_group_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Reference');

                if($this->department > 0) {
                    $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->head_hunter = $object->head_hunter->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->job_fair = $object->job_fair->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->job_ads = $object->job_ads->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->linkedin = $object->linkedin->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->outsourcing = $object->outsourcing->where('trans_recruitment_recruit.department_id', $this->department);
                    $object->reference = $object->reference->where('trans_recruitment_recruit.department_id', $this->department);
                }

                if($this->period > 0) {
                    $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->head_hunter = $object->head_hunter->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->job_fair = $object->job_fair->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->job_ads = $object->job_ads->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->linkedin = $object->linkedin->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->outsourcing = $object->outsourcing->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->reference = $object->reference->where('trans_recruitment_recruit.period_id', $this->period);
                }

                $object->fulfilled = $object->fulfilled->first()->count_request;
                $object->head_hunter = $object->head_hunter->first()->count_request;
                $object->job_fair = $object->job_fair->first()->count_request;
                $object->job_ads = $object->job_ads->first()->count_request;
                $object->linkedin = $object->linkedin->first()->count_request;
                $object->outsourcing = $object->outsourcing->first()->count_request;
                $object->reference = $object->reference->first()->count_request;

                array_push($data, $object);
            }
        } else if($this->sheet == 'dept') {
            $department_all = Departement::get();

            foreach($department_all as $d) {
                $object = (object) array();
                $object->department_id = $d->department_id;
                $object->department_name = $d->department_name;

                $object->fulfilled = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

                $object->head_hunter = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Head Hunter');

                $object->job_fair = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Job Fair');

                $object->job_ads = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Job Ads');

                $object->linkedin = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'LinkedIn');

                $object->outsourcing = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Outsourcing');

                $object->reference = Recruit::query()
                    ->selectRaw('FORMAT(COUNT(trans_recruitment_recruit.recruit_id), 0) AS count_request')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                    ->where('trans_recruitment_recruit.department_id', $d->department_id)
                    ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                    ->where('trans_recruitment_recruit.hiring_resource', 'Reference');

                if($this->grade_group > 0) {
                    $object->fulfilled = $object->fulfilled->where('g.grade_group_id', $this->grade_group);
                    $object->head_hunter = $object->head_hunter->where('g.grade_group_id', $this->grade_group);
                    $object->job_fair = $object->job_fair->where('g.grade_group_id', $this->grade_group);
                    $object->job_ads = $object->job_ads->where('g.grade_group_id', $this->grade_group);
                    $object->linkedin = $object->linkedin->where('g.grade_group_id', $this->grade_group);
                    $object->outsourcing = $object->outsourcing->where('g.grade_group_id', $this->grade_group);
                    $object->reference = $object->reference->where('g.grade_group_id', $this->grade_group);
                }

                if($this->period > 0) {
                    $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->head_hunter = $object->head_hunter->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->job_fair = $object->job_fair->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->job_ads = $object->job_ads->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->linkedin = $object->linkedin->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->outsourcing = $object->outsourcing->where('trans_recruitment_recruit.period_id', $this->period);
                    $object->reference = $object->reference->where('trans_recruitment_recruit.period_id', $this->period);
                }

                $object->fulfilled = $object->fulfilled->first()->count_request;
                $object->head_hunter = $object->head_hunter->first()->count_request;
                $object->job_fair = $object->job_fair->first()->count_request;
                $object->job_ads = $object->job_ads->first()->count_request;
                $object->linkedin = $object->linkedin->first()->count_request;
                $object->outsourcing = $object->outsourcing->first()->count_request;
                $object->reference = $object->reference->first()->count_request;

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

                $event->sheet->getDelegate()->setAutoFilter('A2:'.$highestColumn.'2');

                $event->sheet->getDelegate()->mergeCells('A1:A2');
                $event->sheet->getDelegate()->mergeCells('B1:B2');
                $event->sheet->getDelegate()->mergeCells('C1:C2');
                $event->sheet->getDelegate()->mergeCells('D1:I1');

                $event->sheet->getDelegate()->getStyle('A3:A'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('C3:I'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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