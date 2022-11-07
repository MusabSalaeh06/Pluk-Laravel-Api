<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class org_invite extends Model
{
    protected $primaryKey = 'invite_id';
    protected $keyType = 'string';
    protected $table = 'org_invites';
    protected $filllable = ['invite_id','org_id','member_id','owner_invite','status']; 
    
    public function owner()
        {
            return $this->belongsTo(member::class,'owner_invite','member_id',);
        }
    public function member()
        {
            return $this->belongsTo(member::class,'member_id','member_id',);
        }
    public function org()
        {
            return $this->belongsTo(group_org::class,'org_id','org_id',);
        }

}
