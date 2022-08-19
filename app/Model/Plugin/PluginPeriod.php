<?php

namespace App\Model\Plugin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginPeriod extends Model
{
    use SoftDeletes;

    protected $table = 'mst_plugin_period';
    protected $primaryKey = 'period_id';
    protected $fillable = [
                            "period_name",
                            "period_id",
                            "created_at",
                            "created_by",
                            "deleted_by",
                            "deleted_at",
                            "period_status"
                        ];

}