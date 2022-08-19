<?php

namespace App\Model\Koperasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Plugin\PluginPeriod;
use App\Model\User;
use App\Model\Koperasi\OrderDetail;

class OrderHeader extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_koperasi_order_header';
    protected $primaryKey = 'order_header_id';
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

    public function Period()
    {
        return $this->belongsTo(PluginPeriod::class,'period_id','period_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user_nik','user_nik');
    }

    Public function Detail()
    {
        return $this->hasMany(OrderDetail::class,'order_header_id','order_header_id');
    }
}
