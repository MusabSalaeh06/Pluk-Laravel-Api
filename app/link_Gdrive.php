<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class link_Gdrive extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'link_gdrives';
    protected $filllable = ['id','lesson_id','name','description','link','owner']; 
}
