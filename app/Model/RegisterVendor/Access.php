<?php

namespace App\Model\RegisterVendor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use SoftDeletes;
    protected $connection = 'reg_vendor';
    protected $table = 'mst_rv_access';
    protected $primaryKey = 'access_id';
    protected $guarded = [];

    public function User()
    {
        return $this->hasMany('App\Model\User','user_id','user_id');
    }
}
