<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class my_job extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'my_jobs';
    protected $filllable = ['id','member_id','wp_name','start','end','job_title']; 
    
}
