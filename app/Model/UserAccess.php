<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $table = 'mst_main_user_access';
    protected $primaryKey = 'user_access_id';
    protected $guarded  = [];
}
