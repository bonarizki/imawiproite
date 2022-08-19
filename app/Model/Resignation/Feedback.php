<?php

namespace App\Model\Resignation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes; 

    protected $table ="mst_resignation_feedback";
    protected $primaryKey = "resign_feedback_id";
    protected $guarded = [];

    public function Resign(){
        return $this->hasOne('App\Model\Resignation\Resign','resign_id','resign_id');
    }
}
