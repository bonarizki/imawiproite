<?php

namespace App\Model\Resignation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clearance extends Model
{
    use SoftDeletes;
    
    protected $table = "mst_resignation_clearance_question";
    protected $primaryKey = "clearance_question_id";
    protected $guarded = [];

    public function Department()
    {
        return $this->belongsTo("App\Model\Departement","department_id","department_id");
    }
}
