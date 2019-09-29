<?php

namespace Helmi\Models\Responses;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChecklistItems extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ChecklistItem::collection($this->collection);
        // return parent::toArray( ChecklistItem::collection($this->collection) );
    }
}
