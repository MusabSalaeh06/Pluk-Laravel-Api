<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class quiz_answer extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'quiz_answers'; 
    protected $fillable = ['id','set_id','qh_id','result','member_id'];
    public function quiz()
    {
        return $this->belongsTo(quiz::class,'id','result',);
    }
}
