<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalMilestoneNextDetail extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_milestone_next_detail';
    protected $primaryKey = 'appraisal_milestone_next_detail_id';
}
