<?php

namespace App\Model\Plugin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginMonth extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_plugin_month';
    protected $primaryKey = 'month_id';
    protected $fillable = [
                            "month_name",
                            "month_sequence",
                            "created_by",
                            "deleted_at",
                            "deleted_by"
                        ];
}