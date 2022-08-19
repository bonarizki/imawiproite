<?php

namespace App\Model;

use App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'mst_main_user_log';
    protected $primaryKey = 'user_log_id';
    protected $fillable = [
        'user_log_mac',
        'user_log_menu',
        'user_log_status',
        'user_log_info',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function users()
    {
        return $this->hasOne(User::class);
    }
}
