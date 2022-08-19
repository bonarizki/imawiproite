<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_user_type';
    protected $primaryKey = 'type_id';
    protected $fillable = [
                            "type_name",
                            "created_by",
                            "updated_by",
                            "deleted_at"
                        ];

    public function User(){
        return $this->hasMany('App\Model\User','type_id','type_id');
    }
}
