<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Ticketing\ProductCategory;

class ProductSubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_product_sub_category';
    protected $primaryKey = 'sub_category_id';
    protected $guarded = [];
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    protected $with = ['Category'];

    public function Category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }
}
