<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalMilestoneDetail extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_milestone_detail';
    protected $primaryKey = 'appraisal_milestone_detail_id';
}
