<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getCode() == 404) {
                return response()->view('errors.' . '404', [], 404);
            }
            if ($exception->getCode() == 401) {
                return response()->view('errors.' . '401', [], 401);
            }
            if ($exception->getCode() == 419) {
                return response()->view('errors.' . '419', [], 419);
            }
            if ($exception->getCode() == 500) {
                return response()->view('errors.' . '500', [], 500);
            }
        }
        return parent::render($request, $exception);
    }
}
