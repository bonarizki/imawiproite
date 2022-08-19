<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Koperasi\Product;

class OrderLimit extends Model
{
    use SoftDeletes;

    protected $table = 'mst_koperasi_order_limit';
    protected $primaryKey = 'order_limit_id';
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
        return $this->hasOne(Product::class,'category_id','category_id');
    }
}
