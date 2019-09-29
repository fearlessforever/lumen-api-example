<?php

namespace Helmi\Models\Responses;

use Illuminate\Http\Resources\Json\Resource;

class ChecklistItem extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'=> $this->id ,
            'item_id'=> $this->id ,
            'checklist_id'=> $this->checklist_id ,
            'is_complete'=> (bool) $this->is_completed ,
        ];
        if( isset($this->name))$data['name'] = $this->name;
        if( isset($this->created_at))$data['created_at'] = $this->created_at;
        if( isset($this->updated_at))$data['updated_at'] = $this->updated_at;

        return $data;
    }
}
