<?php
namespace Helmi\Exceptions;

class DataIsEmpty extends Exception{
    protected $statusCode=404;
    protected $message = 'Data not found';
}