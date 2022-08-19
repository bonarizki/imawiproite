<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\User;

class TypeTicketing extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_type';
    protected $primaryKey = 'type_id';
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
        return $this->belongsTo(User::class,'agent_nik','user_nik');
    }
}
