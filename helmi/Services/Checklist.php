<?php
namespace Helmi\Services;

use Helmi\Models\DB\Checklist as Model;
use Helmi\Models\DB\ChecklistItem as ModelItems;
use Illuminate\Http\Request;

// ============= Resource Models
use Helmi\Models\Requests\ChecklistRequest;
use Helmi\Models\Requests\PaginationParams;
use Helmi\Models\Requests\ChecklistCompletes ;

use Helmi\Models\Responses\Checklist as ChecklistResponse;
use Helmi\Models\Responses\ChecklistCollection ;
use Helmi\Models\Responses\ChecklistItem;
// ============= END OF Resource Models

class Checklist{
    
    public function create( Request $req ){
        //Resource::withoutWrapping();
        
        $resource = new ChecklistRequest($req);
        $resource = $resource->toArray();
        $currentUser = $req->user();
        $createdData = Model::create([
            'object_domain'=> $resource['data']['attributes']['object_domain'],
            'object_id'=> $resource['data']['attributes']['object_id'],
            'description'=> $resource['data']['attributes']['description'],
            'due'=> $resource['data']['attributes']['due'],
            'urgency'=> $resource['data']['attributes']['urgency'],
            'created_by' => $currentUser->id ,
        ]);

        if( is_array($resource['data']['attributes']['items']) )
        {
            $items =[];
            foreach( $resource['data']['attributes']['items'] as $val ){
                $items[]=[
                    'name'=> $val,'user_id'=>$currentUser->id
                ];
            }
            $createdData->items()->createMany( $items );
        }
        

        return new ChecklistResponse( $createdData ); 
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
        $params = new PaginationParams($req);
        $included = [];
        if( in_array( $params->include ,['created_by_user','updated_by_user','items'] ) ){
            $included[]=$params->include;
        }
        
        $data = Model::with($included)->paginate( $params->page_limit );
        
        return new ChecklistCollection( $data ); 
    }

    public function get( $id ){
        $fetchedData = $this->getById($id);
        return new ChecklistResponse( $fetchedData ); 
    }

    public function delete( $id ){
        $fetchedData = $this->getById($id);
        $fetchedData->delete();
        return response('The 204 response.' , 204); 
    }

    private function getById($id){
        $fetchedData = Model::with(['created_by_user','updated_by_user','items'])->find($id);
        if( empty($fetchedData) )
            throw new \Helmi\Exceptions\DataIsEmpty;
        return $fetchedData;
    }

    public function setCompleteMany( Request $req , $isComplete = false ){
        $request = new ChecklistCompletes( $req );
        $request = $request->toArray(null) ;
        if( empty($request['data']) )
            throw new \Helmi\Exceptions\InvalidPayload;
        $ids = array_map(function($val){
            return $val['item_id'];
        } , $request['data'] );

        $items = ModelItems::whereIn('id', $ids)->select('id','checklist_id','is_completed')->get();
        if( empty($items))
            throw new \Helmi\Exceptions\DataIsEmpty;
        // SAVE data
        foreach($items as $val){
            $val->is_completed = $isComplete ;
            $val->save();
        }
        return ChecklistItem::collection($items);
    }
}