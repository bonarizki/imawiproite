<?php

namespace App\Model\Training;

use Illuminate\Database\Eloquent\Model;
use App\Model\Training\Training;
use Illuminate\Database\Eloquent\SoftDeletes;
class TrainingApproval extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_training_approval';
    protected $primaryKey = 'training_approval_id';
    protected $guarded = [];
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    public function User()
    {
        return $this->belongsTo('App\Model\User','training_requester_nik','user_nik');
    }

    public function Training()
    {
        return $this->belongsTo(Training::class,'training_id','training_id');
    }
}
