<?php

namespace App\Api\V1\Book\Http\Controllers;

use App\Api\V1\Book\Http\Requests\BookRequest;
use App\Api\V1\Book\Http\Resources\BookResource;
use App\Common\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function books()
    {

    }

    public function book(Book $book): BookResource
    {
        return BookResource::make($book);
    }

    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());

        return BookResource::make($book)->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function updatePartial(BookRequest $request, Book $book)
    {
        //todo
        return BookResource::make($book)->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return BookResource::make($book)->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function remove(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

}
