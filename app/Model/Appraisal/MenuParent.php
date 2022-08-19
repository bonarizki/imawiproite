<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuParent extends Model
{
	use SoftDeletes;
	
    protected $table = 'mst_appraisal_menu_parent';
    protected $primaryKey = 'menu_parent_id';
}
