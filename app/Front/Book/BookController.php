<?php

namespace App\Front\Book;

class BookController extends Controller
{
    public function index()
    {
        return view('book.list');
    }
}
