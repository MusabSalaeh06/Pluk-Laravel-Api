<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class link_youtube extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'link_youtubes';
    protected $filllable = ['id','lesson_id','name','description','link','owner']; 
}
