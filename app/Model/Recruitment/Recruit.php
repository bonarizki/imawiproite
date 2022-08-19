<?php

namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruit extends Model
{
    use SoftDeletes;
    
    protected $table = 'trans_recruitment_recruit';
    protected $primaryKey = 'recruit_id';
}
