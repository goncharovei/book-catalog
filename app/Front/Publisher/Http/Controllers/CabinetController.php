<?php

namespace App\Front\Publisher\Http\Controllers;

use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CabinetController extends Controller
{
    public function __construct(private readonly PublisherTokenService $tokenService)
    {
        $this->middleware(function (Request $request, Closure $next): Response
        {
           $this->tokenService->setDependencies($request->user());
            return $next($request);
        });
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
