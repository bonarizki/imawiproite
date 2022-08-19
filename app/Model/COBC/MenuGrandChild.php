<?php

namespace App\Model\COBC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGrandChild extends Model
{
	use SoftDeletes;

    protected $table = 'mst_cobc_menu_grand_child';
    protected $primaryKey = 'menu_grand_child_id';
}
