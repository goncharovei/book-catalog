<?php

namespace App\Front\Book\Http\Controllers;

use App\Front\Book\Http\DataTables\BookDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        return view('book.list');
    }

    public function dataTableItems(BookDataTable $dataTable): JsonResponse
    {
        return $dataTable->ajax();
    }
}
