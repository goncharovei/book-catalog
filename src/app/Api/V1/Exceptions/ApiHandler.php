<?php

namespace App\Api\V1\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

final readonly class ApiHandler
{
    public function __construct(private Exceptions $exceptions)
    {
    }

    public function handler(): void
    {
        $this->exceptions->handler->respondUsing(function (Response $response, \Throwable $e, Request $request)
        {
            if (!($response instanceof JsonResponse))
            {
                return $response;
            }

            $this->logging($response, $e, $request);

            $errors = [
                'response' => $this->responseError($response, $e),
                'validation' => $this->validationErrors($e)
            ];

            return $response->setData(compact('errors'));
        });
    }

    private function responseError(Response $response, \Throwable $e): array
    {
        return [
            'message' => $e->getMessage(),
            'code' => $e->getCode() ?: $response->getStatusCode()
        ];
    }

    private function validationErrors(\Throwable $e): array
    {
        if (!($e instanceof ValidationException))
        {
            return [];
        }

        return $e->validator->errors()->toArray();
    }

    private function logging(Response $response, \Throwable $e, Request $request): void
    {
        Log::channel('api')->error(print_r([
            'message' => $e->getMessage(),
            'code' => [
                'error' => $e->getCode(),
                'response' => $response->getStatusCode()
            ],
            'file' => $e->getFile() . ' (' . $e->getLine() . ')',
            'request' => [
                'user_id' => Auth::user()?->id,
                'uri' => $request->getUri(),
                'content' => $request->getContent()
            ]
        ], true), [__CLASS__]);
    }

}
