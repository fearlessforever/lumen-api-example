<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
  return $router->app->version();
});

$router->get('test',function(){
  throw new Helmi\Exceptions\Unauthorized;
});
$router->group(['prefix' => 'user'],function() use ($router){
  $router->get('/token', [
    function (Request $request ) {
      $user = Auth::user();
      $user = $request->user();
      return response()->json( $user );
    }
  ]);
});

