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
        return [
            'name'=> $this->name ,
            'is_complete'=> (bool) $this->is_complete ,
            'created_at'=> $this->created_at ,
            'updated_at'=> $this->updated_at ,
        ];
    }
}
