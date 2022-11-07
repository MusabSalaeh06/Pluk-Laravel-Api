<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyOrgResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //date_default_timezone_set("Asia/Bangkok");
            return [
                'org_id' => $this->org_id,
                'org_name' => $this->org_name,
                'description' => $this->description,
                'org_tel' => $this->org_tel,
                'org_owner' => $this->owner->name." ".$this->owner->surname,
            ];
    }
}
