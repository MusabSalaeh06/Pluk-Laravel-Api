<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'videos';
    protected $filllable = ['id','lesson_id','name','description','file','owner'];
}
