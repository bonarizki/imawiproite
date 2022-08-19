<?php

namespace App\Model\Recruitment;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class StandardLeadTime extends Model
{
    use SoftDeletes;
    
	protected $table = 'mst_recruitment_standard_lead_time';
    protected $primaryKey = 'standard_lead_time_id';
}
