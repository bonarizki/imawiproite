<?php

namespace App\Model\Training;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Training\TrainingParticipants;

class Feedback extends Model
{
    use SoftDeletes;

    protected $table = 'mst_training_feedback';
    protected $primaryKey = 'training_feedback_id';
    protected $guarded = [];
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    public function TrainingParticipants()
    {
        return $this->belongsTo(TrainingParticipants::class,'training_participant_id','training_participant_id');
    }
}
