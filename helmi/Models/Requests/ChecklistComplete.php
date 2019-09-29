<?php

namespace Helmi\Models\Requests;

use Illuminate\Http\Resources\Json\Resource;

class ChecklistComplete extends Resource
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
            'item_id' => $this->item_id
        ];
    }
}
