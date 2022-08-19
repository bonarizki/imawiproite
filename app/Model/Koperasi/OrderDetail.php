<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Koperasi\Product;

class OrderDetail extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_koperasi_order_detail';
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
