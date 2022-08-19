<?php

namespace App\Model\Training;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessPosition extends Model
{
    use SoftDeletes; 

    protected $table = 'mst_training_access_position';
    protected $primaryKey = 'access_position_id';
    protected $guarded = [];

    public function Department()
    {
        return $this->hasOne('App\Model\Departement','department_id','department_id');
    }
}
