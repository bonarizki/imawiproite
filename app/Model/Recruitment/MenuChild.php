<?php

namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuChild extends Model
{
	use SoftDeletes;
	
    protected $table = 'mst_recruitment_menu_child';
    protected $primaryKey = 'menu_child_id';
}
