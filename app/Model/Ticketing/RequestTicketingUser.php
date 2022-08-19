<?php

namespace App\Model\Ticketing;

use Illuminate\Database\Eloquent\Model;
use App\Model\User;

class RequestTicketingUser extends Model
{
    protected $table = 'trans_ticketing_detail_request_user';
    protected $primaryKey = 'request_user_id';

    protected $hidden = [
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at"
    ];

    protected $with = ['User'];

    public function User()
    {
        return $this->hasOne(User::class, 'user_nik', 'user_nik');
    }
}
