<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation'
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e): JsonResponse|Response
    {
        // If the request expects a JSON response, then return a JSON formatted exception response
        if ($request->expectsJson()) {
            // Log the exception
            Log::error($e);

            // If the exception is a ValidationException, then return a 422 Unprocessable Entity response
            if ($e instanceof ValidationException) {
                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

                return $this->apiResponse([
                    'message' => 'Validation Failed !',
                    'success' => false,
                    'exception' => $e,
                    'error_code' => $statusCode,
                    'errors' => $e->errors()
                ], $statusCode);
            }

            // If the exception is a ModelNotFoundException, then return a 404 Not Found response
            if ($e instanceof ModelNotFoundException) {
                $statusCode = Response::HTTP_NOT_FOUND;

                return $this->apiResponse([
                    'message' => 'Resource could not be found !',
                    'success' => false,
                    'exception' => $e,
                    'error_code' => $statusCode
                ], $statusCode);
            }

            // If the exception is a UniqueConstraintViolationException, then return a 500 Internal Server Error response
            if ($e instanceof UniqueConstraintViolationException) {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

                return $this->apiResponse([
                    'message' => 'Duplicate entry found !',
                    'success' => false,
                    'exception' => $e,
                    'error_code' => $statusCode
                ], $statusCode);
            }

            // If the exception is a QueryException, then return a 500 Internal Server Error response
            if ($e instanceof QueryException) {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

                return $this->apiResponse([
                    'message' => 'Could not execute query',
                    'success' => false,
                    'exception' => $e,
                    'error_code' => $statusCode
                ], $statusCode);
            }

            // If the exception is an Exception or an Error, then return a 500 Internal Server Error response
            if ($e instanceof Exception || $e instanceof Error) {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

                return $this->apiResponse([
                    'message' => 'An unexpected error happened, please try again later',
                    'success' => false,
                    'exception' => $e,
                    'error_code' => $statusCode
                ], $statusCode);
            }
        }

        // If the request does not expect a JSON response, then return the parent's render response
        return parent::render($request, $e);
    }
}