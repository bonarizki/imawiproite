<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;

class FinalScoreTemp extends Model
{
    protected $table = 'trans_appraisal_final_score_temp';
    protected $fillable = [
    	'nik',
    	'employee',
    	'department',
    	'level',
    	'final_score',
    	'confidential_summary',
    	'user_id'
    ];
}
