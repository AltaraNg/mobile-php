<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Response;
use App\Helper\HttpResponseCodes;
use App\Helper\HttpResponseHelper;
use App\Helper\HttpResponseMessages;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $e
     * @return Response
     */
    public function render($request, Throwable $e)
    {

        if ($request->is('api*')) {
            if ($e instanceof ValidationException) { //handle validation errors
                $data = ["errors" => $e->validator->getMessageBag()->getMessages()];
                return HttpResponseHelper::createErrorResponse(HttpResponseMessages::FAILED_VALIDATION, HttpResponseCodes::FAILED_VALIDATION, $data, HttpResponseCodes::UNPROCESSABLE_ENTITY);
            } elseif ($e instanceof ModelNotFoundException) {
                return HttpResponseHelper::createErrorResponse(
                    HttpResponseMessages::RESOURCE_NOT_FOUND,
                    HttpResponseCodes::RESOURCE_NOT_FOUND
                );
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                return HttpResponseHelper::createErrorResponse(
                    HttpResponseMessages::ROUTE_NOT_FOUND,
                    HttpResponseCodes::ROUTE_NOT_FOUND,
                    [],
                    404
                );
            } elseif ($e instanceof AuthenticationException) {
                return HttpResponseHelper::createErrorResponse($e->getMessage(), HttpResponseCodes::RESOURCE_AUTHORISATION_ERROR, [], HttpResponseCodes::UNAUTHENTICATED);
            } elseif ($e instanceof QueryException) {
                $errorCode = $e->errorInfo[1];
                switch ($errorCode) {
                    case 1062: //code duplicate entry
                        return HttpResponseHelper::createErrorResponse($e->getMessage(), HttpResponseCodes::RESOURCE_AUTHORISATION_ERROR, [], HttpResponseCodes::UNAUTHENTICATED);
                        break;
                    case 1364: // you can handel any auther error
                        return HttpResponseHelper::createErrorResponse($e->getMessage(), HttpResponseCodes::RESOURCE_AUTHORISATION_ERROR, [], HttpResponseCodes::UNAUTHENTICATED);
                        break;
                }
                return HttpResponseHelper::createErrorResponse($e->getMessage(), HttpResponseCodes::RESOURCE_AUTHORISATION_ERROR, [], HttpResponseCodes::UNAUTHENTICATED);
            } elseif ($e instanceof PostTooLargeException) {
                return HttpResponseHelper::createErrorResponse(
                    HttpResponseMessages::FILE_TOO_LARGE,
                    HttpResponseCodes::UNABLE_TO_PROCESS,
                    [],
                    HttpResponseCodes::UNPROCESSABLE_ENTITY
                );
            } elseif ($e instanceof NotFoundHttpException) {
                return HttpResponseHelper::createErrorResponse(
                    'Route not found',
                    HttpResponseCodes::NOT_FOUND,
                    [],
                    HttpResponseCodes::NOT_FOUND
                );
            } else {
                return HttpResponseHelper::createErrorResponse(
                    HttpResponseMessages::EXCEPTION_THROWN,
                    HttpResponseCodes::EXCEPTION_THROWN,
                    [
                        "error_message" => $e->getMessage()
                    ],
                    400
                );
            }
        }
        return parent::render($request, $e);
    }
}
