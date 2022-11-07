<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group_org extends Model
{
    protected $primaryKey = 'org_id';
    protected $keyType = 'string';
    protected $table = 'group_orgs';
    protected $filllable = ['org_id','org_name','description','org_tel','county','road',
    'alley','house_number','group_no','sub_district','district','province','ZIP_code','book_cer','org_owner']; 
    
    public function owner()
    {
        return $this->belongsTo(member::class,'org_owner','member_id');
    }
}
