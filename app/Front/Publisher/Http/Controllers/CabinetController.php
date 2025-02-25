<?php

namespace App\Front\Publisher\Http\Controllers;

use App\Common\Service\PublisherToken\PublisherTokenService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function __construct(private readonly PublisherTokenService $tokenService)
    {
    }

    public function index(Request $request): Renderable
    {
        $this->tokenService->setPublisher($request->user());

        return view('publisher.cabinet', [
            'token' => $this->tokenService->getPlainTextToken()
        ]);
    }
}
