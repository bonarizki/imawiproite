<?php

namespace App\Model\Awards;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Awards\AnswerL1;

class ManagementQuestion extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_awards_questions';
    protected $primaryKey = 'question_id';
    protected $guarded = [];

}
