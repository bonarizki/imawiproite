<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalStaffObjectiveNext extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_staff_objective_next';
    protected $primaryKey = 'appraisal_staff_objective_next_id';
}
