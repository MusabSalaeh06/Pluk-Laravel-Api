<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class testvdoc extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'testvdocs';
    protected $filllable = ['id','title','description','up_image','up_video','link_y','link_g','document']; 
}
