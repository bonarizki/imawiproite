<?php

namespace App\Model\RegisterVendor;

use Illuminate\Database\Eloquent\Model;

class AccessPosition extends Model
{
    protected $connection = 'reg_vendor';
    protected $table = 'mst_rv_access_position';
    protected $primaryKey = 'access_position_id';
    protected $guarded = [];

    public function Department()
    {
        return $this->hasOne('App\Model\Departement','department_id','department_id');
    }
}
