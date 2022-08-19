<?php

namespace App\Model\Plugin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingSystem extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_plugin_setting_system';
    protected $primaryKey = 'setting_system_id';
    protected $fillable = [
            'setting_system_name',
            'setting_system_status',
            'created_by',
            'updated_by',
            'deleted_by'
    ];
}