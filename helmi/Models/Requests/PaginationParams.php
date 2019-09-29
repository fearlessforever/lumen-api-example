<?php

namespace Helmi\Models\Requests;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class PaginationParams extends Resource
{
    function __construct( \Illuminate\Http\Request $req ){
        $validated = [
            'include'       => (string) $req->include ,
            'filer'         => (string) $req->filer ,
            'sort'          => (string) $req->sort ,
            'fields'        => (string) $req->fields ,
            'page_limit'    => ((int)$req->page_limit )?:10,
            'page_offset'   => ((int)$req->page_offset )?:0,
        ];
        $req->merge($validated);
        // $req = Resource::collection( $req->all() ) ;
        parent::__construct( $req );
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'include'       => '',
            'filer'         => '',
            'sort'          => '',
            'fields'        => '',
            'page_limit'    => 10,
            'page_offset'   => 0,
        ];
    }
}
