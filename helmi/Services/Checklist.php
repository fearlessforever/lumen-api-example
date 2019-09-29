<?php
namespace Helmi\Services;

use Helmi\Models\DB\Checklist as Model;
use Illuminate\Http\Request;

// Models
use Helmi\Models\Requests\ChecklistRequest;
use Helmi\Models\Requests\PaginationParams;
use Helmi\Models\Responses\Checklist as ChecklistResponse;
use Helmi\Models\Responses\ChecklistCollection ;

class Checklist{
    
    public function create( Request $req ){
        //Resource::withoutWrapping();
        
        $resource = new ChecklistRequest($req);
        $resource = $resource->toArray();
        
        Model::create([
            'object_domain'=> $resource['data']['attributes']['object_domain'],
            'object_id'=> $resource['data']['attributes']['object_id'],
            'description'=> $resource['data']['attributes']['description'],
            'due'=> $resource['data']['attributes']['due'],
            'urgency'=> $resource['data']['attributes']['urgency'],
            'created_by' => $req->user()->id ,
        ]);

        return response()->json( $resource );
    }

    public function update( Request $req ){
        $resource = new ChecklistRequest($req);
        $resource = $resource->toArray();

        $fetchedData = $this->getById( $req->id );
        $fetchedData->object_domain = $resource['data']['attributes']['object_domain'];
        $fetchedData->object_id = $resource['data']['attributes']['object_id'];
        $fetchedData->description = $resource['data']['attributes']['description'];
        $fetchedData->due = $resource['data']['attributes']['due'];
        $fetchedData->urgency = $resource['data']['attributes']['urgency'];
        $fetchedData->last_update_by =  $req->user()->id  ;

        $fetchedData->save();
        return new ChecklistResponse( $fetchedData ); 
    }

    public function gets( Request $req  ){
        $resource = new PaginationParams($req);
        $included = [];
        if( in_array( $resource->include ,['created_by_user','updated_by_user'] ) ){
            $included[]=$resource->include;
        }
        // dd($resource->page_limit );
        $data = Model::with($included)->paginate( $resource->page_limit );
        // $data = Model::paginate();
        
        return new ChecklistCollection( $data ); 
    }

    public function get( $id ){
        $fetchedData = $this->getById($id);
        return new ChecklistResponse( $fetchedData ); 
    }

    private function getById($id){
        $fetchedData = Model::find($id);
        if( empty($fetchedData) )
            throw new \Helmi\Exceptions\DataIsEmpty;
        return $fetchedData;
    }
}