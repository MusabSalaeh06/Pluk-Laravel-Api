<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class manager extends Authenticatable
{
    use Notifiable;
    protected $guard = 'manager';
    protected $primaryKey = 'manager_id';
    protected $keyType = 'string';
    protected $table = 'managers';
    protected $filllable = ['manager_id','email','password','user_status_id','name','surname','gender','tell','manager_image','school_name','school_Detail',
                            'school_image','Address_hn','Address_m','Address_t','Address_a','Address_j','Address_p','school_tell']; 
    public function usn()
        {
            return $this->belongsTo(user_status::class,'user_status_id','user_status_id',);
        }
}
