<?php

namespace App\Model\Training;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingMethod extends Model
{
    use SoftDeletes;

    protected $table = 'mst_training_method';
    protected $primaryKey = 'method_id';
    protected $guarded = [];
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];
}
