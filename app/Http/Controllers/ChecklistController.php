<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helmi\Services\Checklist;

class ChecklistController extends Controller
{
    function __construct( Checklist $service ){
        $this->service = $service ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        return $this->service->gets($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        if( !$request->isJson() )
            throw new \Helmi\Exceptions\InvalidPayload;

        $this->customValidate($request ,[
            'data.attributes.object_domain'=>'required|string',
            'data.attributes.object_id'=>'required|string',
            'data.attributes.task_id'=>'required|string',
            'data.attributes.items'=>'required|array',
        ]);
        
        return $this->service->create( $request );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function setComplete( Request $request ){
        return $this->service->setCompleteMany( $request , true );
    }

    public function setInComplete( Request $request ){
        return $this->service->setCompleteMany( $request , false );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->get($id);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if( !$request->isJson() )
            throw new \Helmi\Exceptions\InvalidPayload;

        $request->merge(['id'=>$id ] );
        
        $this->customValidate($request ,[
            'data.attributes.object_domain'=>'required|string',
            'data.attributes.object_id'=>'required|string',
            'data.attributes.task_id'=>'required|string',
            'data.attributes.items'=>'required|array',
        ]);
        
        return $this->service->update( $request );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->delete( $id );
    }
}
