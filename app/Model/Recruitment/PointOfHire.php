<?php

namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointOfHire extends Model
{
	use SoftDeletes;
	
    protected $table = 'mst_recruitment_point_of_hire';
    protected $primaryKey = 'point_of_hire_id';
}
