<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_main_user_title';
    protected $primaryKey = 'title_id';
    protected $fillable = [
                            "title_name",
                            "created_by",
                            "updated_by",
                            "deleted_at"
                        ];
    
    public function User(){
        return $this->hasMany('App\Model\User','title_id','title_id');
    }

}
