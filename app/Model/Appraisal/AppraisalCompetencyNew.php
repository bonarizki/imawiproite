<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalCompetencyNew extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_competency_new';
    protected $primaryKey = 'appraisal_competency_new_id';
}
