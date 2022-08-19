<?php

namespace App\Model\Awards\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGrandChild extends Model
{
    use SoftDeletes;

    protected $table = 'mst_awards_menu_grand_child';
    protected $primaryKey = 'menu_grand_child_id';
    protected $fillable = [
        'menu_grand_child_name',
        'menu_grand_child_icon',
        'menu_grand_child_status',
        'menu_grand_child_url',
        'menu_child_id',
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
        return $this->belongsTo('App\Model\Awards\Menu\MenuChild','menu_child_id','menu_child_id');
    }
}
