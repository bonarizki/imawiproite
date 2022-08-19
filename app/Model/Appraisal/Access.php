<?php

namespace App\Model\Appraisal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_appraisal_access';
    protected $primaryKey = 'access_id';
    protected $guarded  = [];
}
