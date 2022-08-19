<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competency extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_appraisal_competency';
    protected $primaryKey = 'competency_id';
}
