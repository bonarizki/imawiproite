<?php

namespace App\Model\Resignation\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuChild extends Model
{
    use SoftDeletes;

    protected $table = 'mst_resignation_menu_child';
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

    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];
    

    public function MenuGrandChild(){
        return $this->hasMany('App\Model\Resignation\Menu\MenuGrandChild','menu_child_id','menu_child_id');
    }

    public function Menu(){
        return $this->belongsTo('App\Model\Resignation\Menu\Menu','menu_parent_id','menu_parent_id');
    }
}
