<?php

namespace App\Model\Resignation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClearanceAnswer extends Model
{
    use SoftDeletes; 

    protected $table = "mst_resignation_clearance_answer";
    protected $primaryKey = "clearance_answer_id";
    protected $guarded = [];

    public function Resign(){
        return $this->belongsTo("App\Model\Resignation\Resign","resign_id","resign_id");
    }
}
