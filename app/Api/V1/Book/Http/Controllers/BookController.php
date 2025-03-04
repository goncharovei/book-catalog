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

/**
 * Class BookController
 * @package App\Api\V1\Book\Http\Controllers
 *
 * @OA\Info(
 *       title="Catalog of books API",
 *       version="1"
 *   )
 *
 * @OA\Server(url="https://book-catalog.local/api/v1")
 *
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    type="apiKey",
 *    name="Authorization",
 *    in="header",
 *    scheme="bearer"
 *  )
 *  @OA\OpenApi(
 *     security={{"bearerAuth": {}}}
 *  )
 *
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/books",
     *     tags={"Books"},
     *     summary="Get list of books",
     *     description="Returns list of books",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              required={"data"},
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Book")
     *              )
     *          )
     *     )
     * )
     */
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
