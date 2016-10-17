<?php

namespace base\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e){
        //dd($e);
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e){
        //dd($request);
        //dd($e);
        //echo "ENTRANDO...";
        /*if ($e instanceof ModelNotFoundException) {
            echo "1";
            $e = new NotFoundHttpException($e->getMessage(), $e);            
        }

        if ($e instanceof NotFoundHttpException) {
            echo "2";
            //$e = new NotFoundHttpException($e->getMessage(), $e);            
        }

        if ($e instanceof ErrorException) {
            echo "3";
            //$e = new NotFoundHttpException($e->getMessage(), $e);            
        }
        //dd($e);

        if ($e->getStatusCode() == 500) {
            //return response()->view('errors.500', [], 500);
            return response()->view('errors.404', [], 404);
        }

        if ($e->getStatusCode() == 401) {
            //return response()->view('errors.401', [], 401);
            return response()->view('errors.404', [], 404);
        }*/
        if ($e->getCode() == 0){
            return response()->view('errors.404', [], 404);
        }

        if ($e->getStatusCode() == 404) {
            return response()->view('errors.404', [], 404);
            //App::abort(404);
            //return view('erorrs.404');
        }

        return parent::render($request, $e);
    }
}
