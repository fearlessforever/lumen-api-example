<?php

namespace Helmi\Models\Requests;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistCompletes extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        if( is_array($this->data) ){
            foreach($this->data as $val){
                if(isset($val['item_id']))
                $data[]=[
                    'item_id'=> $val['item_id']
                ];
            }
        }
        return[
            'data'=> $data
        ];
    }
}
