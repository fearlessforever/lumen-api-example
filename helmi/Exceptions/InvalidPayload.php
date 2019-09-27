<?php
namespace Helmi\Exceptions;

class InvalidPayload extends Exception{
    protected $statusCode = 400;
    protected $message = 'Bad Request';
    public $attributes = [];

    function __construct( $var='' ){
        if( is_string($var) ){
            parent::__construct($var);
        }elseif( $var instanceof \Illuminate\Validation\ValidationException  ){
            $this->attributes = $var->response->original;
        }
    }
}