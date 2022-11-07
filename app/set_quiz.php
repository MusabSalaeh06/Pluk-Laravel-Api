<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class set_quiz extends Model
{
    use Notifiable;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'set_quizzes'; 
    protected $fillable = ['id','lesson_id','set_name','time','stastus'];
}
