<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalStaffCompetency extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_staff_competency';
    protected $primaryKey = 'appraisal_staff_competency_id';
}
