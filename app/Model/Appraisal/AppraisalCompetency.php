<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalCompetency extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_competency';
    protected $primaryKey = 'appraisal_competency_id';
}
