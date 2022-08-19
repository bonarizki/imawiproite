<?php
 
namespace App\Exports\Recruitment;
 
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
 
class RateExport implements WithMultipleSheets
{
    private $period;
    private $grade_group;
    private $department;

    public function __construct($period, $grade_group, $department)
    {
        $this->period = $period;
        $this->grade_group = $grade_group;
        $this->department = $department;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new RateSheet('gg', $this->period, $this->grade_group, $this->department);
        $sheets[] = new RateSheet('dept', $this->period, $this->grade_group, $this->department);

        return $sheets;
    }
}