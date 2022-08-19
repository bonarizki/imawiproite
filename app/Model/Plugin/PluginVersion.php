<?php

namespace App\Model\Plugin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PluginVersion extends Model
{
    use SoftDeletes;

    protected $table = 'mst_plugin_version';
    protected $primaryKey = 'version_id';
    protected $fillable = [
                            'version_code',
                            'version_name',
                            'version_status',
                            'created_by',
                            'deleted_at',
                            'updated_by'
                        ];

    public static function UpdateVersion()
    {
        $query = "UPDATE mst_plugin_version set version_status=0";
        DB::select($query);
        return true;
    }
}