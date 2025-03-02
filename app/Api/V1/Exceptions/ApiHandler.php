<?php

namespace App\Api\V1\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

            Log::error(print_r([
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

            return $response->setData(['error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode() ?: $response->getStatusCode()
            ]]);
        });
    }

}
