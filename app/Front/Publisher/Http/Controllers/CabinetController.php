<?php

namespace App\Front\Publisher\Http\Controllers;

use App\Front\Publisher\Service\CabinetPublisherService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function __construct(private readonly CabinetPublisherService $service)
    {
    }

    public function index(Request $request): Renderable
    {
        return view('publisher.cabinet', [
            'token' => $this->service->setPublisher($request->user())->currentAccessToken()
        ]);
    }
}
