<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class course_category extends Model
{
    
    protected $primaryKey = 'cc_id';
    protected $keyType = 'string';
    protected $table = 'course_categories';
    protected $filllable = ['cc_id','name','short_name']; 
}
