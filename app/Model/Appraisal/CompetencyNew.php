<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetencyNew extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_appraisal_competency_new';
    protected $primaryKey = 'competency_new_id';
}
