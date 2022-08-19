<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalMilestone extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_milestone';
    protected $primaryKey = 'appraisal_milestone_id';
}
