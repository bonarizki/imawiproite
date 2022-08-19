<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalStaffMain extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_appraisal_staff_main';
    protected $primaryKey = 'appraisal_staff_id';
}
