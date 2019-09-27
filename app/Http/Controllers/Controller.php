<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function customValidate( ...$var ){
        try{
            $this->validate( ...$var );
        }catch( \Illuminate\Validation\ValidationException $exception ){
            throw new \Helmi\Exceptions\InvalidPayload($exception);
        }
    }
}
