<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $table = "mst_koperasi_banner";
    protected $primaryKey = "banner_id";
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
