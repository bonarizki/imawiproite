<?php

namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGrandChild extends Model
{
	use SoftDeletes;

    protected $table = 'mst_recruitment_menu_grand_child';
    protected $primaryKey = 'menu_grand_child_id';
}
