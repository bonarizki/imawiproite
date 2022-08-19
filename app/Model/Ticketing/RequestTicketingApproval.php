<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Ticketing\RequestTicketingHeader;

class RequestTicketingApproval extends Model
{
    use SoftDeletes;

    protected $table = 'mst_ticketing_approval';
    protected $primaryKey = 'ticketing_approval_id';
    protected $guarded = [];
    public $incrementing = false;
    
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        // "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    protected $with = [
        "TicketingApproval1",
        "TicketingApproval2",
        "TicketingApproval3",
        "TicketingApproval4",
        "TicketingApproval5",
        "TicketingApproval6",
        "TicketingApprovalit1",
        "TicketingApprovalit2",
    ];

    public function Header()
    {
        return $this->hasOne(RequestTicketingHeader::class,'ticket_id','ticket_id');
    }

    public function TicketingApproval1()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_1','user_nik')->withTrashed();
    }

    public function TicketingApproval2()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_2','user_nik')->withTrashed();
    }

    public function TicketingApproval3()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_3','user_nik')->withTrashed();
    }

    public function TicketingApproval4()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_4','user_nik')->withTrashed();
    }

    public function TicketingApproval5()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_5','user_nik')->withTrashed();
    }

    public function TicketingApproval6()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_6','user_nik')->withTrashed();
    }

    public function TicketingApprovalit1()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_it1','user_nik')->withTrashed();
    }

    public function TicketingApprovalit2()
    {
        return $this->belongsTo('App\Model\User','ticketing_approval_nik_it2','user_nik')->withTrashed();
    }
}
