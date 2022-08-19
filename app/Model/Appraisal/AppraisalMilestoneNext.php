<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalMilestoneNext extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_milestone_next';
    protected $primaryKey = 'appraisal_milestone_next_id';
}
