<?php

namespace Helmi\Models\Responses;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChecklistCollection extends ResourceCollection
{
    private $meta;
    private $metaLinks;

    function __construct( $resource ){
        $this->meta = [
            'total' => $resource->total(),
            'count' => $resource->count(),
        ];
        
        $extra = [
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'last_page' => $resource->lastPage(),
        ];
        // dd($extra);
        $extra['next_page'] = $extra['current_page'] +1;
        $extra['prev_page'] = $extra['current_page'] -1;
        // dd($resource);
        $this->metaLinks = [
            "first" => route('checklist.list') . "?page[limit]={$extra['per_page']}&page[offset]=0",
            "last"  => ($extra['current_page'] == $extra['last_page']) ? null : route('checklist.list') . "?page[limit]={$extra['per_page']}&page[offset]={$extra['last_page']}",
            "next"  => ($extra['last_page'] < $extra['next_page']) ? null : route('checklist.list') . "?page[limit]={$extra['per_page']}&page[offset]={$extra['next_page']}",
            "prev"  => ($extra['current_page'] > 1 && $extra['current_page'] < $extra['last_page'] ) ? route('checklist.list') . "?page[limit]={$extra['per_page']}&page[offset]={$extra['prev_page'] }" : null 
        ];

        $resource = $resource->getCollection();
        parent::__construct( $resource );
    }
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray( $request)
    {
        return parent::toArray( Checklist::collection($this->collection) );
    }

    public function with($request)
    {
        return [
            'links' => $this->metaLinks,
            'meta'  => $this->meta
        ];
    }
}
