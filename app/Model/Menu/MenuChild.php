<?php

namespace App\Model\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuChild extends Model
{
    use SoftDeletes;

    protected $table = 'mst_main_menu_child';
    protected $primaryKey = 'menu_child_id';
    protected $fillable = [
                            'menu_child_id',
                            'menu_child_name',
                            'menu_child_icon',
                            'menu_child_status',
                            'menu_child_url',
                            'menu_parent_id',
                            'created_by',
                            'updated_by',
                            'deleted_at',
                            'deleted_by',
                            ];
    

    public function MenuGrandChild(){
        return $this->hasMany('App\Model\Menu\MenuGrandChild','menu_child_id','menu_child_id')->orderBy('menu_grand_child_name','asc');
    }
}
