<?php

namespace App\Api\V1\Book\Http\Resources;

use App\Common\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BookResource
 * @package App\Api\V1\Book\Http\Resources
 *
 * @OA\Schema(
 *   schema="Book",
 *   title="Book",
 *   @OA\Property(
 *       property="id",
 *       type="integer",
 *      format="int64"
 *   ),
 *   @OA\Property(
 *       property="isbn",
 *       type="string"
 *   ),
 *   @OA\Property(
 *        property="name",
 *        type="string"
 *    ),
 *     @OA\Property(
*         property="author_names",
*         type="array",
*         @OA\Items(ref="#/components/schemas/NameAuthor")
*      ),
 *     @OA\Property(
 *      property="year_publication",
 *      type="date",
 *      format="Y"
 *     ),
 *     @OA\Property(
 *       property="detail_link",
 *       type="string"
 *      )
 *  )
 * @OA\Schema(
 *    schema="NameAuthor",
 *    title="Name of Author",
 *    type="string"
 * )
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var Book $this
         */
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'name' => $this->name,
            'author_names' => $this->authors,
            'year_publication' => $this->year_publication,
            'detail_link' => $this->detail_link
        ];
    }
}
