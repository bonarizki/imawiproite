<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_module';
    protected $primaryKey = 'module_id';
    protected $fillable = [
                            "module_name",
                            "module_url",
                            "module_status",
                            "created_by",
                            "updated_by",
                            "deleted_at",
                            "deleted_by",
                            "module_image"
                        ];
}
