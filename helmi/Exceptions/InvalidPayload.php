<?php
namespace Helmi\Exceptions;

class InvalidPayload extends Exception{
    protected $statusCode = 403;
    protected $message = 'Bad Request';
}