<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class my_school extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'my_schools';
    protected $filllable = ['id','member_id','school_name','start','end','edu_level','fac_name']; 
}
