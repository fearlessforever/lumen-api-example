<?php
namespace Helmi\Exceptions;

class Unauthorized extends Exception{
    protected $statusCode = 401;
    protected $message = 'Not Authorized';
}