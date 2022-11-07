<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class student extends Authenticatable
{
    use Notifiable;
    protected $guard = 'student';
    protected $primaryKey = 'student_id';
    protected $keyType = 'string';
    protected $table = 'students'; 
    protected $fillable = ['student_id','email','password','user_status_id','name','surname','gender','tell','student_image','manager_id'];
    public function sch()
        {
            return $this->belongsTo(manager::class,'manager_id','manager_id',);
        }
        public function usn()
        {
            return $this->belongsTo(user_status::class,'user_status_id','user_status_id',);
        }
}
