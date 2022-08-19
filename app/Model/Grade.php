<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Grade extends Model
{
    use SoftDeletes ;
    
    protected $table = 'mst_main_user_grade';
    protected $primaryKey = 'grade_id';
    protected $guarded = [];
    
    public function User(){
        return $this->hasMany('App\Model\User','grade_id','grade_id');
    }

    public function GradeGroup(){
        return $this->hasOne('App\Model\GradeGroup','grade_group_id','grade_group_id');
    }


}
