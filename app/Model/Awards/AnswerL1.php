<?php

namespace App\Model\Awards;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AnswerL1 extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_awards_answer_l1';
    protected $primaryKey = 'answer_id';
    protected $guarded = [];
}