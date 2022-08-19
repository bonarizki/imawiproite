<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\User;

class SystemApplication extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_list_system';
    protected $primaryKey = 'system_id';
    protected $guarded = [];

    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    protected $with = ["User"];

    public function User()
    {
        return $this->belongsTo(User::class, 'system_pic_nik','user_nik');
    }
}
