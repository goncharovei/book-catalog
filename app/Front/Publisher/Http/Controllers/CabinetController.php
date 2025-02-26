<?php

namespace App\Front\Publisher\Http\Controllers;

use App\Front\Publisher\Service\PublisherToken\PublisherTokenService;
use Illuminate\Contracts\Support\Renderable;

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
}
