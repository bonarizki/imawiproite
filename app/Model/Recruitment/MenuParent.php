<?php

namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuParent extends Model
{
	use SoftDeletes;
	
    protected $table = 'mst_recruitment_menu_parent';
    protected $primaryKey = 'menu_parent_id';
}
