<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

// use Helmi\Exceptions\DataIsEmpty;
// use Helmi\Exceptions\InvalidPayload;
// use Helmi\Exceptions\Unauthorized;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    private $defaultHeaders=[
      'Access-Control-Allow-Origin'=>'*',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        $defaultResponse=[
          'status'=>0,
          'error'=>''
        ];
        
        if( method_exists( $exception , 'getStatusCode') ){
          
          $errorDetail = new \stdClass();
          $errorDetail->statusCode = $exception->getStatusCode();
          $errorDetail->message = $exception->getMessage();
          
          $errorDetail->statusCode = empty($errorDetail->statusCode) ? 500 : $errorDetail->statusCode ;
         
          switch( $errorDetail->statusCode ){
            case 404:
              $defaultResponse = array_merge($defaultResponse , [
                'status'=> $errorDetail->statusCode,
                'error'=> empty($errorDetail->message) ? 'Data not found' : $errorDetail->message ,
              ]);
              break;
            case 403:
              $defaultResponse = array_merge($defaultResponse , [
                'status'=> $errorDetail->statusCode,
                'error'=> empty($errorDetail->message) ? 'Invalid Payload' : $errorDetail->message ,
              ]);
              break;
            default: 
              $defaultResponse = array_merge($defaultResponse , [
                'status'=> $errorDetail->statusCode ,
                'error'=> empty($errorDetail->message) ? 'Server Error' : $errorDetail->message , 
              ]);
              break;
          }

          return response()->json( $defaultResponse , $errorDetail->statusCode , $this->defaultHeaders  );
        }
        
        return parent::render($request, $exception);
    }
}
