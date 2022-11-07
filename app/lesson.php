<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    protected $primaryKey = 'lesson_id';
    protected $keyType = 'string';
    protected $table = 'lessons';
    protected $filllable = ['lesson_id','id','lesson_name','lesson_detail','lesson_status','lesson_owner']; 
    
    public function co()
        {
            return $this->belongsTo(course::class,'id','id');
        }

}