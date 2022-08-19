<?php

namespace App\Model\Koperasi;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes; 

    protected $table = 'mst_koperasi_member';
    protected $primaryKey = 'member_id';
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
        return $this->hasOne(User::class,'user_nik','user_nik');
    }
}
