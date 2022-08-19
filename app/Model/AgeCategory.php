<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeCategory extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_age_category';
    protected $primaryKey = 'age_category_id';
    protected $guarded = [];
}
