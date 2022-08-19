<?php

namespace App\Model\Koperasi\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'mst_koperasi_menu_parent';
    protected $primaryKey = 'menu_parent_id';
    protected $fillable = [
        'menu_parent_id',
        'menu_parent_name',
        'menu_parent_icon',
        'menu_parent_status',
        'menu_parent_url',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    public function MenuChild(){
        return $this->hasMany('App\Model\Koperasi\Menu\MenuChild','menu_parent_id','menu_parent_id')->orderBy('menu_child_name');
    }

}
