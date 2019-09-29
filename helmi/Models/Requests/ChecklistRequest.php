<?php

namespace Helmi\Models\Requests;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;

class ChecklistRequest extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request=null)
    {
        return [
            'data'=>[
                'attributes'=>[
                    "object_domain" => @(string)($this->data['attributes']['object_domain'] ?: ''),
                    "object_id"     => @(int)($this->data['attributes']['object_id'] ?: '') ,
                    "due"           => @( $this->data['attributes']['due'] ? Carbon::parse((string)$this->data['attributes']['due']) : null ) ,
                    "urgency"       => @(int)($this->data['attributes']['urgency'] ?: '') ,
                    "description"   => @(string)$this->data['attributes']['description'] ?: '' ,
                    "task_id"       => @(string)$this->data['attributes']['task_id'] ?: '' ,
                    "items"         => @(array)($this->data['attributes']['items'] ?: null),
                ]
            ]
        ];
    }
    
}
