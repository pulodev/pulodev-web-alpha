<?php

namespace App\Exceptions;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

    }

    public function render($request, Throwable $e)
    {
        //if token missmatch
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
              return redirect()
                  ->back()
                  ->withInput($request->input())->with('warning', 'mohon maaf, silahkan submit sekali lagi');
        }

        return parent::render($request, $e);
    }
}
