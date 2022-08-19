<?php

namespace App\Model\Awards;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_awards_access';
    protected $primaryKey = 'access_id';
    protected $guarded = [];
    
    public function User(){
        return $this->belongsTo('App\Model\User','user_id','user_id');
    }
}