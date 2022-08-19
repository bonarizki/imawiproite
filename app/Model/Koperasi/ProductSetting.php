<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSetting extends Model
{
    use SoftDeletes;

    protected $table = "mst_koperasi_product_setting";
    protected $primaryKey = 'product_setting_id';
    protected $connection= 'mysql';
    protected $guarded = [];

}
