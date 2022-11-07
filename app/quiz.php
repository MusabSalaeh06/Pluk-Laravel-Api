<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class quiz extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'quizzes'; 
    protected $fillable = ['id','qh_id','quiz','result'];
}
