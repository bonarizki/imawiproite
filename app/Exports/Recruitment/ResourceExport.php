<?php
 
namespace App\Exports\Recruitment;
 
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
 
class ResourceExport implements WithMultipleSheets
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

        $sheets[] = new ResourceSheet('gg', $this->period, $this->grade_group, $this->department);
        $sheets[] = new ResourceSheet('dept', $this->period, $this->grade_group, $this->department);

        return $sheets;
    }
}