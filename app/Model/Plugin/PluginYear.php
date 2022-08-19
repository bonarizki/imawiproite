<?php

namespace App\Model\Plugin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PluginYear extends Model
{
    use SoftDeletes; 

    protected $table = 'mst_plugin_year';
    protected $primaryKey = 'year_id';
    protected $fillable = [
                            'year_name',
                            'year_status',
                            'created_by',
                            'deleted_at',
                            'updated_by',
                            'deleted_by'
                        ];
}