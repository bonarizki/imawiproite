<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalPeriod extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_appraisal_period';
    protected $primaryKey = 'appraisal_period_id';
}
