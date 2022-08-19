<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferingComparison extends Model
{
    use SoftDeletes;

    protected $table = "mst_ticketing_offering_po";
    protected $primaryKey = 'offering_id';
    protected $guarded = ['offering_id'];

    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

}
