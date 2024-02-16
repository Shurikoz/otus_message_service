<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render(
        $request,
        Throwable $e
    ) {
        $response = $this->handleApiException($e);

        if (config('app.debug')) {
            $response = array_merge($response, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
//                'trace' => $e->getTrace()
            ]);
        }

        return response(
            $response
        );
    }
    private function handleApiException(mixed $exception): array
    {
        return self::renderResponse(
            false,
            $exception->getCode(),
            $exception->getMessage()
        );
    }

    public static function renderResponse(bool $success, int $code, string $message, array $data = []): array
    {
        return [
            "success" => $success,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}
