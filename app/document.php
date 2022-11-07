<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'documents';
    protected $filllable = ['id','lesson_id','name','description','file','owner'];
}
