<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class member extends Authenticatable
{
    use Notifiable;
    protected $guard = 'member';
    protected $primaryKey = 'member_id';
    protected $keyType = 'string';
    protected $table = 'members';
    protected $filllable = ['email','password','member_id','name','surname','gender','tel','birth_day','card_id','profile','county'
    ,'road','alley','house_number','group_no','sub_district','district','province','ZIP_code']; 

    public function count_co()
    {
        return $this->belongsTo(course::class,'member_id','course_owner',);
    }
    public function count_org()
    {
        return $this->belongsTo(group_org::class,'member_id','org_owner',);
    }
    public function count_inv()
    {
        return $this->belongsTo(org_invite::class,'member_id','member_id',);
    }
    public function count_org_my_join_inv()
    {
        return $this->belongsTo(respond_inv::class,'member_id','member_id',);
    }
    public function count_org_my_join_req()
    {
        return $this->belongsTo(respond_req::class,'member_id','member_id',);
    }
}