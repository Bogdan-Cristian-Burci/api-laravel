<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use App\Traits\ApiResponses;



class Handler extends ExceptionHandler
{
    use ApiResponses;

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
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request,Throwable $e): JsonResponse
    {
        return $this->handleException($request, $e);
    }

    /**
     * @throws Throwable
     */
    public function handleException($request, Exception $exception)
    {

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(405,'The specified method for the request is invalid');
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse(404,'The specified URL cannot be found');
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getCode(),$exception->getMessage());
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse(500,'Unexpected Exception. Try later');

    }

}
