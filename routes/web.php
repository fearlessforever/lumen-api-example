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
  throw new Helmi\Exceptions\InvalidPayload;
});
$router->group(['prefix' => 'user'],function() use ($router){
  $router->post('/','UserController@create');

  $router->get('/token', 'UserController@getToken');
  $router->get('/check-token', ['middleware'=>'auth',function( App\Http\Controllers\UserController $controller , Request $req ){
    return $controller->check($req);
  }]);
});

