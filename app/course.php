<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class course extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'courses';
    protected $filllable = ['id','cc_id','course_id','course_name','course_detail','course_type','course_img','course_status','price','course_owner']; 
    
        public function owner()
        {
            return $this->belongsTo(member::class,'course_owner','member_id',);
        }
        public function cc()
        {
            return $this->belongsTo(course_category::class,'cc_id','cc_id',);
        }
        public function enr()
        {
            return $this->belongsTo(enroll::class,'id','course_id',);
        }

}
