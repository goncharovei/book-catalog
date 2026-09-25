<?php

namespace App\Front\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class FrontHandler
{
    public function __construct(private Exceptions $exceptions)
    {

    }

    public function handler(): void
    {
        $this->ajaxExceptions();
    }

    private function ajaxExceptions(): void
    {
        $this->exceptions->handler->respondUsing(function (Response $response, \Throwable $e, Request $request)
        {
            if (!$request->isXmlHttpRequest())
            {
                return $response;
            }

            return $response->setData([
                'exception' => $e->getMessage()
            ]);
        });
    }
}
