<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'images';
    protected $filllable = ['id','lesson_id','name','description','file','owner'];
}

