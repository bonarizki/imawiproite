<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetencyStaff extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_appraisal_competency_staff';
    protected $primaryKey = 'competency_staff_id';
}
