<?php

namespace App\Model\COBC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessPosition extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_cobc_access_position';
    protected $primaryKey = 'access_position_id';
}
