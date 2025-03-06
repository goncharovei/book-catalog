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
        $this->tokenService->refresh();

        return response()->json([
            'token' => $this->tokenService->getPlainTextToken()
        ]);
    }

    public function revoke(): JsonResponse
    {
        $this->tokenService->revoke();

        return response()->json();
    }
}
