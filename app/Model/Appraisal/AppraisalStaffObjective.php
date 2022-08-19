<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalStaffObjective extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_staff_objective';
    protected $primaryKey = 'appraisal_staff_objective_id';
}
