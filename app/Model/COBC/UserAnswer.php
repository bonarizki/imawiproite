<?php

namespace App\Model\COBC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAnswer extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_cobc_user_answer';
    protected $primaryKey = 'answer_id';
}
