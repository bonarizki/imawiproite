<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Ticketing\ProductSubCategory;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_product_category';
    protected $primaryKey = 'category_id';
    protected $guarded = [];

    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    // protected $with = [
    //     'SubProductCategory'
    // ];

    public function SubProductCategory()
    {
        return $this->hasMany(ProductSubCategory::class, 'category_id', 'category_id');
    }
}
