<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuChild extends Model
{
	use SoftDeletes;
	
    protected $table = 'mst_appraisal_menu_child';
    protected $primaryKey = 'menu_child_id';
}
