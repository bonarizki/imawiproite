<?php

namespace App\Model\Awards;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\User;
use App\Model\Awards\AnswerL1;
use App\Model\Awards\AnswerL2;

class ManagemenApprovalAwards extends Model
{
    use SoftDeletes;
    
    protected $table = 'mst_awards_approval';
    protected $primaryKey = 'approval_id';
    protected $guarded = [];

    protected $with = [
        'User',
        'Appraise',
        'Approve'
    ];

    public function User()
    {
        return $this->belongsTo(User::class,'user_nik','user_nik');
    }

    public function Appraise()
    {
        return $this->belongsTo(User::class,'appraise_by','user_nik');
    }

    public function Approve()
    {
        return $this->belongsTo(User::class,'approve_by','user_nik');
    }

    public function AnswerL1()
    {
        return $this->belongsTo(AnswerL1::class,'user_nik','user_nik');
    }

    public function AnswerL2()
    {
        return $this->belongsTo(AnswerL2::class,'user_nik','user_nik');
    }
}
