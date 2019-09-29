<?php

namespace Helmi\Models\Responses;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'email'=> $this->email ,
            'updated_at'=> $this->updated_at ,
        ];
    }
}
