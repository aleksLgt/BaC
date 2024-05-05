<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        NotFoundHttpException::class
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

    public function render($request, $e)
    {
        if ($e instanceof NotFoundHttpException)
            return $this->formatException($e, (int)$e->getStatusCode(), 'Not found');
        if ($e instanceof ModelNotFoundException)
            return $this->formatException($e, Response::HTTP_BAD_REQUEST);
        if ($e instanceof MethodNotAllowedHttpException)
            return $this->formatException($e,(int)$e->getStatusCode());
        if ($e instanceof AuthorizationException)
            return $this->formatException($e, Response::HTTP_FORBIDDEN);
        if ($e instanceof JWTException)
            return $this->formatException($e,Response::HTTP_UNAUTHORIZED);

        return parent::render($request, $e);
    }

    public function formatException($e,$code, $message = '')
    {
        $message = $message ?: (string)$e->getMessage();
        return response()->json([
            'error' => last(explode('\\',get_class($e))),
            'message' => $message
        ], $code);
    }
}
