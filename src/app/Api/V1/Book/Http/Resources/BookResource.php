<?php

namespace App\Api\V1\Book\Http\Resources;

use App\Common\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


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
