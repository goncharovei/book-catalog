<?php

namespace App\Api\V1\Book\Http\Controllers;

use App\Api\V1\Book\Http\Requests\BookRequest;
use App\Api\V1\Book\Http\Requests\BookUpdatePartialRequest;
use App\Api\V1\Book\Http\Resources\BookResource;
use App\Common\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function books(Request $request): AnonymousResourceCollection
    {
        return BookResource::collection($request->user()->books()->paginate());
    }

    public function book(Book $book): BookResource
    {
        return BookResource::make($book);
    }

    public function store(BookRequest $request)
    {
        $book = $request->user()->books()->create($request->validated());

        return BookResource::make($book)->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function updatePartial(BookUpdatePartialRequest $request, Book $book)
    {
        $book->update($request->validated());

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
