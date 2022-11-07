<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class org_request extends Model
{
    protected $primaryKey = 'request_id';
    protected $keyType = 'string';
    protected $table = 'org_requests';
    protected $filllable = ['request_id','org_id','member_id','status']; 

    public function member()
        {
            return $this->belongsTo(member::class,'member_id','member_id',);
        }   
    public function owner()
        {
            return $this->belongsTo(member::class,'member_id','member_id',);
        }
    public function org()
        {
            return $this->belongsTo(group_org::class,'org_id','org_id',);
        }
}
