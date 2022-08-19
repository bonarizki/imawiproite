<?php
 
namespace App\Exports\COBC;
 
use App\Model\User;
use App\Model\COBC\COBCPeriod;
use App\Model\Plugin\PluginPeriod;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
 
class ReportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithTitle
{
    private $period;

    public function __construct($period)
    {
        $this->period = $period;
    }

    public function title(): string
    {
        return 'Report COBC Refreshment Test';
    }

    public function headings(): array
    {
    	return [
            'NO',
            'NIK',
            'NAME',
            'TITLE',
            'DEPARTMENT',
            'PHASE 1',
            'PHASE 2',
            'PHASE 3',
            'STATUS'
    	];
    }

    public function map($r): array
    {
        $data = [
            $r->user_id,
            $r->user_nik,
            $r->user_name,
            $r->title_name,
            $r->department_name,
            $r->phase_1,
            $r->phase_2,
            $r->phase_3
        ];

        if($r->phase_1 == '-') {
            $data[8] = 'Haven\'t taken The Test';
        } else if(((int) $r->phase_1 < 80) && ((int) $r->phase_2 < 80) && ((int) $r->phase_3 < 80)) {
            $data[8] = 'Failed';
        } else if(((int) $r->phase_1 >= 80) || ((int) $r->phase_2 >= 80) || ((int) $r->phase_3 >= 80)) {
            $data[8] = 'Success';
        } else {
            $data[8] = 'In Progress';
        }

        return $data;
    }

    public function query()
    {
        $cobc_period = COBCPeriod::where('period_id', $this->period)->first();
        $report = User::query()
            ->selectRaw('mst_main_user.user_id,
                mst_main_user.user_nik,
                mst_main_user.user_name,
                title.title_name,
                dept.department_name,
                IFNULL((SELECT FORMAT(p1.score, 0)
                    FROM trans_cobc_user_answer p1
                    WHERE p1.user_id = mst_main_user.user_id
                    AND p1.period_id = '.$this->period.'
                    AND p1.phase = 1
                    AND p1.completed = "1"
                    GROUP BY p1.answer_id), "-") AS phase_1,
                IFNULL((SELECT FORMAT(p2.score, 0)
                    FROM trans_cobc_user_answer p2
                    WHERE p2.user_id = mst_main_user.user_id
                    AND p2.period_id = '.$this->period.'
                    AND p2.phase = 2
                    AND p2.completed = "1"
                    GROUP BY p2.answer_id), "-") AS phase_2,
                IFNULL((SELECT FORMAT(p3.score, 0)
                    FROM trans_cobc_user_answer p3
                    WHERE p3.user_id = mst_main_user.user_id
                    AND p3.period_id = '.$this->period.'
                    AND p3.phase = 3
                    AND p3.completed = "1"
                    GROUP BY p3.answer_id), "-") AS phase_3')
            ->leftJoin('mst_main_user_title AS title', 'title.title_id', 'mst_main_user.title_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereRaw('DATEDIFF("'.$cobc_period->cobc_period_end.'", mst_main_user.user_join_date) > 180')
            ->whereIn('gg.grade_group_id', [3,4,5,6,7])
            ->groupBy('mst_main_user.user_id')
            ->orderBy('mst_main_user.user_join_date');

        return $report;
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