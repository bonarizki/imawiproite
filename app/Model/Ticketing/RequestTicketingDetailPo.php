<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Ticketing\OfferingComparison as Comparison;
use App\Model\Ticketing\ProductSubCategory;

class RequestTicketingDetailPo extends Model
{
    use SoftDeletes;

    protected $table = 'trans_ticketing_detail_po';
    protected $primaryKey = 'detail_po_id';
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

    public function Comparison()
    {
        return $this->hasMany(Comparison::class,'detail_po_id','detail_po_id');
    }

    public function SubCategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'sub_category_id','sub_category_id');
    }
}
