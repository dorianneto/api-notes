<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @param  \Exception  $except
     * @return void
     */
    public function report(Exception $except)
    {
        parent::report($except);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $except
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $except)
    {
        if ($except instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['error' => 'token_expired'], 500);
        } else if ($except instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['error' => 'token_invalid'], 500);
        } else if ($except instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            return response()->json(['error' => 'token_expired'], 500);
        } else if ($except instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException) {
            return response()->json(['error' => 'token_not_provided'], 500);
        } else if ($except instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json(['error' => 'method_not_allowed_http'], 500);
        } else if ($except instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json(['error' => 'route_not_found'], 404);
        } else if ($except instanceof \Swift_TransportException) {
            return response()->json(['error' => 'email_authentication_required'], 500);
        }

        return parent::render($request, $except);
    }
}
