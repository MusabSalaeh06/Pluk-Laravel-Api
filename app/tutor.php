<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class tutor extends Authenticatable
{
    use Notifiable;
    protected $guard = 'tutor';
    protected $primaryKey = 'tutor_id';
    protected $keyType = 'string';
    protected $table = 'tutors';
    protected $filllable = ['tutor_id','email','password','user_status_id','name','surname','gender','tell','student_image','status','manager_id','card_id']; 

    public function C_owner()
    {
        return $this->belongsTo(course::class, 'tutor_id','course_owner');
    }
    public function sch()
        {
            return $this->belongsTo(manager::class,'manager_id','manager_id',);
        }
        public function usn()
        {
            return $this->belongsTo(user_status::class,'user_status_id','user_status_id',);
        }
}
