<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\RegisterVendor\AccessPosition;

class Departement extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'mst_main_department';
    protected $primaryKey = 'department_id';
    protected $fillable = [
                            "department_name",
                            "created_by",
                            "updated_by",
                            "deleted_at"
                        ];

    public function User()
    {
        return $this->hasMany('App\Model\User','department_id','department_id');
    }

    public function Clearance()
    {
        return $this->hasMany('App\Model\Resignation\Clearance','department_id','department_id');
    }

    public function AccessPosition()
    {
        return $this->hasOne('App\Model\Resignation\AccessPosition','department_id','department_id');
    }

    public function AccessPositionRegven()
    {
        return $this->hasOne(AccessPosition::class,'department_id','department_id');
    }
}
