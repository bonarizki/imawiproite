<?php

namespace App\Model\COBC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
	use SoftDeletes;
	
    protected $table = 'mst_cobc_question';
    protected $primaryKey = 'question_id';
}
