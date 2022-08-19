<?php

namespace App\Model\Training;

use Illuminate\Database\Eloquent\Model;
use App\Model\Training\Vendor;
use App\Model\Training\TrainingApproval;
use App\Model\Training\TrainingParticipants;
use App\Model\Training\Category;
use App\Model\Training\TrainingMethod;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes; 

    protected $table = 'mst_training_list';
    protected $primaryKey = 'training_id';
    protected $guarded = [];
    public $incrementing = false;
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    public function Vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id','vendor_id');
    }

    public function TrainingApproval()
    {
        return $this->hasOne(TrainingApproval::class,'training_id','training_id');
    }

    public function Participant()
    {
        return $this->hasMany(TrainingParticipants::class,'training_id','training_id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }

    public function Method()
    {
        return $this->belongsTo(TrainingMethod::class,'method_id','method_id');
    }
}
