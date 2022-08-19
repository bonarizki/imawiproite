<?php

namespace App\Model\COBC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAnswerDetail extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_cobc_user_answer_detail';
    protected $primaryKey = 'answer_detail_id';
}
