<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_appraisal_milestone';
    protected $primaryKey = 'milestone_id';
}
