<?php

namespace App\Front\Publisher\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class CabinetController extends Controller
{

    public function index(): Renderable
    {
        return view('publisher.cabinet');
    }
}
