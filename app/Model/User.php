<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\LockableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Model\RegisterVendor\Access;
use App\Model\Koperasi\Member;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, LockableTrait, SoftDeletes;

    protected $table = 'mst_main_user';
    protected $primaryKey = 'user_id';
    protected $guarded = [];
    protected $hidden = [
        "password",
        "remember_token",
        "created_by",
        "created_at",
        "updated_by",
        "updated_at",
        "deleted_by",
        "deleted_at",
        "token_jwt"
    ];

    // public function getAuthPassword()
    // {
    //     return $this->Password;
    // }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function Grade()
    {
        return $this->belongsTo('App\Model\Grade', 'grade_id', 'grade_id');
    }

    public function Title()
    {
        return $this->belongsTo('App\Model\Title', 'title_id', 'title_id');
    }

    public function Type()
    {
        return $this->belongsTo('App\Model\Type', 'type_id', 'type_id');
    }

    public function Department()
    {
        return $this->belongsTo('App\Model\Departement', 'department_id', 'department_id');
    }

    public function ResignationAccess()
    {
        return $this->hasOne('App\Model\Resignation\Access', 'user_id', 'user_id');
    }

    public function ApprovalMatrix()
    {
        return $this->hasOne('App\Model\ApprovalMatrix', 'user_nik', 'user_nik');
    }

    public function Resign()
    {

        return $this->hasMany('App\Model\Resignation\Resign', 'user_nik', 'user_nik');
    }

    public function TrainingAccess()
    {
        return $this->hasOne('App\Model\Training\Access', 'user_id', 'user_id');
    }

    public function TrainingParticipants()
    {
        return $this->hasOne('App\Model\Training\TrainingParticipants', 'user_nik', 'training_requester_nik');
    }

    public function TicketingAccess()
    {
        return $this->hasOne('App\Model\Ticketing\Access', 'user_id', 'user_id');
    }

    public function KoperasiAccess()
    {
        return $this->hasOne('App\Model\Koperasi\Access', 'user_id', 'user_id');
    }

    public function SalesAwards()
    {
        return $this->hasOne('App\Model\Awards\Access', 'user_id', 'user_id');
    }

    public function AccessRegven()
    {
        return $this->hasOne(Access::class, 'user_id', 'user_id');
    }

    public function Member()
    {
        return $this->hasOne(Member::class, 'user_nik', 'user_nik');
    }

}
