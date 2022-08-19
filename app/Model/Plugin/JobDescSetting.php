<?php

namespace App\Model\Plugin;

use Illuminate\Database\Eloquent\Model;

class JobDescSetting extends Model
{
    protected $table = 'mst_plugin_setting_system_job_desc';
    protected $primaryKey = 'job_desc_setting_id';
}