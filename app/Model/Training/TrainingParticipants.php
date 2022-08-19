<?php

namespace App\Model\Training;

use Illuminate\Database\Eloquent\Model;
use App\Model\Training\Feedback;
use App\Model\Training\Training;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingParticipants extends Model
{
    use SoftDeletes; 

    protected $table = 'mst_training_list_participant';
    protected $primaryKey = 'training_participant_id';
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
        return $this->belongsTo('App\Model\User','training_user_nik','user_nik')->withTrashed();
    }

    public function Feedback()
    {
        return $this->hasOne(Feedback::class,'training_participant_id','training_participant_id');
    }

    public function Training()
    {
        return $this->belongsTo(Training::class,'training_id','training_id');
    }
}
