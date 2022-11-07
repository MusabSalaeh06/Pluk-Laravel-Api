<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'notes';
    protected $filllable = ['id','lesson_id','note','status','org_id','creator']; 
    
    public function lesson_detail()
        {
            return $this->belongsTo(lesson::class,'lesson_id','id');
        }
     public function creator_detail()
        {
            return $this->belongsTo(member::class,'creator','member_id');
        }
}
