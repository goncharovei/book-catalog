<?php

namespace App\Front\Book\Http\Controllers;

class BookController extends Controller
{
    public function index()
    {
        return view('book.list');
    }
}
