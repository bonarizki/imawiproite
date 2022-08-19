<?php

namespace App\Model\COBC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class COBCPeriod extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_cobc_period';
    protected $primaryKey = 'cobc_period_id';
}
