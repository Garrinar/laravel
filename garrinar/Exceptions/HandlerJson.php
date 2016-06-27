<?php

namespace Garrinar\Exceptions;

use Exception;
use Garrinar\Http\Response\BaseResponse;
use Garrinar\Http\Response\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->wantsJson()) {
            $message = $e->getMessage();
            $code = BaseResponse::HTTP_INTERNAL_SERVER_ERROR;

            if ($e instanceof HttpExceptionInterface) {
                return
                    new JsonResponse('Not found', $e->getStatusCode());
            } else {
                return new JsonResponse(['message' => $message, 'trace' => $e->getTrace()], $code);
            }
        } else {
            return parent::render($request, $e);
        }
    }
}
