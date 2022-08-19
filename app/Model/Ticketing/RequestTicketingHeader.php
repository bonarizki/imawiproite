<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Ticketing\Priority;
use App\Model\Ticketing\TypeTicketing;
use App\Model\Plugin\PluginPeriod;
use App\Model\User;
use App\Model\Ticketing\RequestTicketingDetailPo;
use App\Model\Ticketing\RequestTicketingApproval;
use App\Model\Ticketing\RequestTicketingUser;
use App\Model\Ticketing\RequestTicketingDetailCRA;

class RequestTicketingHeader extends Model
{
    use SoftDeletes;

    protected $table = 'trans_ticketing_header';
    protected $primaryKey = 'ticket_id';
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
        'RequestBy',
        'Type'
    ];

    public function Priority()
    {
        return $this->hasOne(Priority::class, 'priority_id', 'priority_id');
    }

    public function Type()
    {
        return $this->hasOne(TypeTicketing::class, 'type_id', 'type_id');
    }

    public function Period()
    {
        return $this->hasOne(PluginPeriod::class, 'period_id', 'period_id');
    }

    public function RequestBy() // relation ke table user untuk mendapatkan detail user yang melakukan request ticketing
    {
        return $this->hasOne(User::class, 'user_nik', 'user_ticketing_request')->withTrashed();
    }

    public function DetailPo() // detail ticketing it po o
    {
        return $this->hasMany(RequestTicketingDetailPo::class, 'ticket_id', 'ticket_id');
    }

    public function Approval()
    {
        return $this->hasOne(RequestTicketingApproval::class, 'ticket_id', 'ticket_id');
    }

    public function DetailRequestAccessUser() // detail ticketing request user
    {
        return $this->hasMany(RequestTicketingUser::class, 'ticket_id', 'ticket_id');
    }

    public function DetailRequestCra()
    {
        return $this->hasOne(RequestTicketingDetailCRA::class, 'ticket_id', 'ticket_id');
    }

    public function NikUpdateBy()
    { // relation ke table user untuk mendapatkan detail user yang melakukan updated_by
        return $this->hasOne(User::class, 'user_name', 'updated_by')->withTrashed();
    }
}
