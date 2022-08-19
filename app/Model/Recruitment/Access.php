<?php

namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_recruitment_access';
    protected $primaryKey = 'access_id';
    protected $guarded  = [];
}
