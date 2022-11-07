<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class respond_req extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'respond_reqs';
    protected $filllable = ['id','request_id','member_id','answer','org_id']; 
    
    public function member()
        {
            return $this->belongsTo(member::class,'member_id','member_id',);
        }
     public function org()
        {
            return $this->belongsTo(group_org::class,'org_id','org_id',);
        }
}
