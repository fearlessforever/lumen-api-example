<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create( Request $request )
    {
        $this->customValidate( $request , [
            'password' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $newUser = \App\User::create([
            'username'=> $request->email ,
            'email' => $request->email ,
            'password' => Hash::make( $request->password ),
            'api_token' => Str::random(60),
            'name'=> '' ,
        ]);

        return response()->json(['message'=>'oke']);
    }

    public function getToken( Request $request ){
        
        $this->customValidate( $request , [
            'password' => 'required',
            'email' => 'required'
        ]);
        $user = \App\User::where('email' , $request->email )->first();
        
        if( !empty($user) && Hash::check(  $request->password , $user->password ) ){
            $token = Str::random(60);
            $user->api_token = $token;
            $user->save();
            
            return response()->json(['token'=>$token]);
        }

        throw new \Helmi\Exceptions\InvalidPayload;
    }

    public function check( Request $request ){
        $user = $request->user();

        return response()->json( $user );
    }
}
