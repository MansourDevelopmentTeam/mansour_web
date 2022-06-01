<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // return parent::render($request, $exception);

        // dd($exception);
        // Define the response
        $code = 500;
        $response = [
            'code' => $code,
            "message" => trans("exceptions.500"),
            "errors" => [$exception->getMessage()],
        ];

        if (!app()->environment('production')) {
            $trace = $exception->getTrace();

            $traceCustom = [
                'file_path' => isset($trace[0]['file']) ? $trace[0]['file'] : '',
                'line' => isset($trace[0]['line']) ? $trace[0]['line'] : '',
            ];

            // $response["errors"]["trace"] = $trace;
            $response["errors"]["custom_trace"] = $traceCustom;
            $response["errors"]["message"] = $exception->getMessage();
        }

        // $code = $exception->getStatusCode();
        // If this exception is an instance of HttpException
        if ($this->isHttpException($exception)) {
            // Grab the HTTP status code from the Exception
            $response["internalMessage"] = $exception->getMessage() ?: "Not Found";
            $code = $exception->getStatusCode();
        }

        if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            $response["userMessage"] = "Invalid Token";
            $response["internalMessage"] = "token_expired";
        } else if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            $response["userMessage"] = "Invalid Token";
            $response["internalMessage"] = "token_invalid";
        } else if ($exception instanceof ValidationException) {
            $response["message"] = current(current($exception->errors()));
            $response["errors"]["errorMessage"] = "Invalid Data";
            $response["errors"]["errorDetails"] = $exception->errors();
            unset($response["errors"]["trace"]);
            unset($response["errors"]["message"]);
            $code = 422;
        }

        if ($exception instanceof AuthenticationException ) {
            $code = 403;
        }

        if ($exception instanceof ModelNotFoundException) {
            $position = strrpos($exception->getModel(), '\\');
            $modelName = substr($exception->getModel(), $position + strlen('\\'));

            $response["message"] = $modelName . " not found with the id: " . implode($exception->getIds(), ", ");
            $code = 404;
        }

        // Return a JSON response with the response array and status code
        $response["code"] = $code;
        return response()->json($response, 200);
    }
}
