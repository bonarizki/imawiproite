<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalMain extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_main';
    protected $primaryKey = 'appraisal_id';
}
