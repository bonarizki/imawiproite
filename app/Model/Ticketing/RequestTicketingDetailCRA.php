<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestTicketingDetailCRA extends Model
{
    use SoftDeletes;

    protected $table = 'trans_ticketing_detail_cra';
    protected $primaryKey = 'cra_id';
    protected $guarded = [];
    public $incrementing = false;
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];
    
    
}