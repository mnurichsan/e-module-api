<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use MilanTarami\ApiResponseBuilder\Facades\ResponseBuilder;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError()
                    ->withHttpCode(401)
                    ->withMessage('Sesi Berakhir')
                    ->build();
            }else{
                return redirect()->route('login');
            }

        });

        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError()
                    ->withHttpCode(405)
                    ->withMessage('Method Not Allowed')
                    ->build();
            }

        });

        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseBuilder::asError()
                    ->withHttpCode(404)
                    ->withMessage('Not Found')
                    ->build();
            }
        });
    }
}
