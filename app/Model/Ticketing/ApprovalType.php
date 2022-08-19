<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalType extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_approval_type';
    protected $primaryKey = 'approval_type_id';
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
