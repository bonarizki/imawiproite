<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\User;

class ModuleAdmin extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_admin';
    protected $primaryKey = 'admin_id';
    protected $guarded = [];
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    public function User()
    {
        return $this->belongsTo(User::class,'admin_nik','user_nik');
    }
}
