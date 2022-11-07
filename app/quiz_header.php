<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class quiz_header extends Model
{
    use Notifiable;
    protected $primaryKey = 'qh_id';
    protected $keyType = 'string';
    protected $table = 'quiz_headers'; 
    protected $fillable = ['qh_id','id','header_name','status'];
}
