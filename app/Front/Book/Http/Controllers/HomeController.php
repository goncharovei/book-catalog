<?php

namespace App\Front\Book\Http\Controllers;

use App\Front\Book\Http\DataTables\BookDataTable;
use App\Front\Book\Http\Requests\BookSearchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('book.list');
    }

    public function dataTableItems(BookSearchRequest $request, BookDataTable $dataTable): JsonResponse
    {
        return $dataTable->setFilterData($request->getDto())->ajax();
    }
}
