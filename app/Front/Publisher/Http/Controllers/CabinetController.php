<?php

namespace App\Front\Publisher\Http\Controllers;

use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

class CabinetController extends Controller
{
    public function __construct(private readonly PublisherTokenService $tokenService)
    {
    }

    public function index(): Renderable
    {
        return view('publisher.cabinet', [
            'token' => $this->tokenService->getPlainTextToken()
        ]);
    }

    public function refresh(): JsonResponse
    {
        try {
            $this->tokenService->refresh();
        } catch (\Throwable $e)
        {
            return response()->json(
                ['exception' => $e->getMessage()]
            );
        }

        return response()->json([
            'token' => $this->tokenService->getPlainTextToken()
        ]);
    }

    public function revoke(): JsonResponse
    {
        try {
            $this->tokenService->revoke();
        } catch (\Throwable $e)
        {
            return response()->json(
                ['exception' => $e->getMessage()]
            );
        }

        return response()->json();
    }
}
