<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeGroup extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_user_grade_group';
    protected $primaryKey = 'grade_group_id';
    protected $guarded = [];

    public function Grade()
    {
        return $this->belongsToMany('App\Model\Grade','grade_group_id','grad_group_id');
    }
}
