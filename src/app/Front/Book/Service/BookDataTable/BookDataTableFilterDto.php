<?php

namespace App\Front\Book\Service\BookDataTable;

final readonly class BookDataTableFilterDto
{
    public function __construct(
        public ?string $searchText = ''
    )
    {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $data): BookDataTableFilterDto
    {
        return new BookDataTableFilterDto(
            searchText: $data['search']
        );
    }
}
