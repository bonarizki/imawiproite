<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;

class CompetencyTemp extends Model
{
    protected $table = 'mst_appraisal_competency_temp';
    protected $fillable = [
    	'department',
    	'level',
    	'competency_eng',
    	'competency_bhs',
    	'user_id'
    ];
}
