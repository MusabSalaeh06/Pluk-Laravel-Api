<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enroll extends Model
{
    protected $primaryKey = 'enroll_id';
    protected $keyType = 'string';
    protected $table = 'enrolls';
    protected $filllable = ['enroll_id','course_id','org_id','member_id','status','pin_code','image','creator']; 
    
    public function co_detail()
        {
            return $this->belongsTo(course::class,'course_id','id');
        }
    public function member_detail()
        {
            return $this->belongsTo(member::class,'member_id','member_id');
        }
     public function org_detail()
        {
            return $this->belongsTo(group_org::class,'org_id','org_id');
        }
}
