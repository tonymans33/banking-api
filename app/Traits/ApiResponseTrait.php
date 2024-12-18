<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    /**
     * Parse and format the API response.
     *
     * @param array $data The response data (success, message, result, errors, exception).
     * @param int $statusCode The HTTP status code.
     * @param array $headers Additional headers to include in the response.
     *
     * @return array The formatted response structure.
     */

    private function parseGivenData(array $data = [], int $statusCode = 200, array $headers = []): array
    {

        $responseStructure = [
            'success' => $data['success'] ?? false,
            'message' => $data['message'] ?? null,
            'result' => $data['result'] ?? null
        ];

        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }

        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }

        if (isset($data['exception']) && ($data['exception'] instanceof \Error || $data['exception'] instanceof \Exception)) {
            if (config('app.env') !== 'production') {
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                    'trace' => $data['exception']->getTrace()
                ];
            }

            if ($statusCode == 200) {
                $statusCode =  Response::HTTP_INTERNAL_SERVER_ERROR;
            }
        }

        if ($data['success'] === false) {
            $responseStructure['error_code'] = $data['error_code'] ?? 1;
        }

        return [
            'content' => $responseStructure,
            'statusCode' => $statusCode,
            'headers' => $headers
        ];
    }


    /**
     * Generate a JSON response with the given data.
     *
     * @param array $data The data to include in the response.
     * @param int $statusCode The HTTP status code for the response.
     * @param array $headers Additional headers to include in the response.
     * @return JsonResponse The JSON response object.
     */
    public function apiResponse(array $data = [], int $statusCode = 200, array $headers = []): JsonResponse
    {
        // Parse the given data to prepare the response structure
        $result = $this->parseGivenData($data, $statusCode, $headers);

        // Return the JSON response with parsed content, status code, and headers
        return response()->json($result['content'], $result['statusCode'], $result['headers']);
    }

    /**
     * Return a successful API response.
     *
     * @param mixed $data The data to be included in the response.
     * @param string $message The message to be included in the response.
     * @return JsonResponse The JSON response object.
     */
    public function sendSuccess(mixed $data, string $message = ''): JsonResponse
    {
        return $this->apiResponse([
            'success' => true,
            'result' => $data,
            'message' => $message
        ]);
    }

    /**
     * Generate an error response.
     *
     * @param string $message The error message to include in the response.
     * @param int $statusCode The HTTP status code for the error response.
     * @param Exception|null $exception The exception that triggered the error, if any.
     * @param int $error_code The custom error code for the response.
     * @return JsonResponse The JSON response object.
     */
    public function sendError(
        string $message = '',
        int $statusCode = 400,
        Exception $exception = null,
        int $error_code = 1
    ): JsonResponse {
        return $this->apiResponse([
            'success' => false,
            'message' => $message,
            'error_code' => $error_code,
            'exception' => $exception
        ], $statusCode);
    }

    /**
     * Generate an unauthorized response.
     *
     * @param string $message The error message to include in the response.
     * @return JsonResponse The JSON response object.
     */
    public function sendUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->sendError($message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Generate a 403 Forbidden response.
     *
     * @param string $message The error message to include in the response.
     * @return JsonResponse The JSON response object.
     */
    public function sendForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->sendError($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Generate an internal server error response.
     *
     * @param string $message The error message to include in the response.
     * @return JsonResponse The JSON response object.
     */
    public function sendInternalServerError(string $message = 'Internal Server Error'): JsonResponse
    {
        return $this->sendError($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * Generate a JSON response with validation errors.
     *
     * @param ValidationException $validationException The validation exception to include in the response.
     * @return JsonResponse The JSON response object.
     */
    public function sendValidationErrors(ValidationException $validationException): JsonResponse
    {
        // Return the JSON response with validation errors
        return $this->apiResponse([
            'success' => false,
            'message' => $validationException->getMessage(),
            'errors' => $validationException->errors()
        ]);
    }
}
