<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class respond_inv extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'respond_invs';
    protected $filllable = ['id','invite_id','org_id','answer','member_id']; 
    
    public function member()
        {
            return $this->belongsTo(member::class,'member_id','member_id',);
        }
     public function org()
        {
            return $this->belongsTo(group_org::class,'org_id','org_id',);
        }
}
