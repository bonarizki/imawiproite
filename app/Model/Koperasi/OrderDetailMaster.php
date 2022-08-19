<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailMaster extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_koperasi_order_detail_master';
    protected $primaryKey = 'order_detail_id';
    protected $guarded = [];

    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id','product_id');
    }
}
