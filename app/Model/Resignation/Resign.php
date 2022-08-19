<?php

namespace App\Model\Resignation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resign extends Model
{
    use SoftDeletes; 
    
    protected $table = 'mst_resignation_resign_list';
    protected $primaryKey = 'resign_id';
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
    protected $with = [
        'ResignApproval1',
        'ResignApproval2',
        'ResignApproval3',
        'ResignApproval4',
        'ResignApproval5',
        'ResignApproval6',
        'ResignApprovalhr',
    ];

    public function ApprovalMatrix()
    {
        return $this->belongsTo('App\Model\ApprovalMatrix','user_nik','user_nik');
    }

    public function User()
    {
        return $this->belongsTo('App\Model\User','user_nik','user_nik')->withTrashed();
    }

    public function ResignApproval1()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_1','user_nik')->withTrashed();
    }

    public function ResignApproval2()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_2','user_nik')->withTrashed();
    }

    public function ResignApproval3()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_3','user_nik')->withTrashed();
    }

    public function ResignApproval4()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_4','user_nik')->withTrashed();
    }

    public function ResignApproval5()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_5','user_nik')->withTrashed();
    }

    public function ResignApproval6()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_6','user_nik')->withTrashed();
    }
    
    public function ResignApprovalhr()
    {
        return $this->belongsTo('App\Model\User','resign_approval_nik_hr','user_nik')->withTrashed();
    }

    public function Feedback()
    {
        return $this->belongsTo('App\Model\Resignation\Feedback','resign_id','resign_id');
    }

    public function ClearanceAnswer()
    {
        return $this->hasOne('App\Model\Resignation\ClearanceAnswer','resign_id','resgin_id');
    }
}
