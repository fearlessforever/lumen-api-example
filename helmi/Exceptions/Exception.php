<?php

namespace Helmi\Exceptions;
use Exception as RealException;

class Exception extends RealException{
    protected $statusCode=0;
    
    public function getStatusCode(){
        return $this->statusCode;
    }
}