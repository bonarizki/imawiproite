<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_priority';
    protected $primaryKey = 'priority_id';
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
