<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyOrgDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'org_id' => $this->org_id,
            'org_name' => $this->org_name,
            'description' => $this->description,
            'org_tel' => $this->org_tel,
            'org_owner' => $this->owner->name." ".$this->owner->surname,
            'address' =>  "เขต :"." ".$this->county." "."ถนน :"." ".$this->road." "."ตรอก/ซอย :"." ".$this->alley." "."บ้านเลขที่ :".
            " ".$this->house_number." "."หมู่ :"." ".$this->group_no." "."ตำบล :"." ".$this->sub_district." "."อำเภอ :".$this->district
            ." "."จังหวัด :"." ".$this->province." "."รหัสไปรษณีย์ :"." ".$this->ZIP_code
        ];
    }
}
