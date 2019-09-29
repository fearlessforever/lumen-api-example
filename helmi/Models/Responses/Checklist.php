<?php

namespace Helmi\Models\Responses;

use Illuminate\Http\Resources\Json\Resource;

class Checklist extends Resource
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
            "type"        => "checklists",
            "id"          => $this->id,
            "attributes"  => [
                "object_domain" => $this->object_domain,
                "object_id"     => $this->object_id ,
                "task_id"       => $this->task_id,
                "description"   => $this->description,
                "is_completed"  => (bool)$this->is_completed,
                "due"           => $this->due,
                "urgency"       => $this->urgency,
                "completed_at"  => null,
                "updated_by"    => $this->last_update_by,
                "updated_by_user" => new User( $this->whenLoaded('updated_by_user') ),
                "created_by"    => $this->created_by ,
                "created_by_user" => new User( $this->whenLoaded('created_by_user') ) ,
                "created_at"    => $this->created_at ,
                "updated_at"    => $this->updated_at ,
                
            ],
            "links"       => [
                "self"=> route('checklist.self',['id'=>$this->id ]) 
            ]
        ];
    }
    
}
