<?php

namespace App\Front\Publisher\Service;

use App\Common\Helper\EnumToArray;

enum AbilityPublisher: string
{
    use EnumToArray;

    case BOOK_READ = 'book:read';
    case BOOK_ADD = 'book:add';
    case BOOK_EDIT = 'book:edit';
    case BOOK_DELETE = 'book:delete';

    public function label(): string
    {
        return match ($this) {
            static::BOOK_READ => 'Read book',
            static::BOOK_ADD => 'Add book',
            static::BOOK_EDIT => 'Edit book',
            static::BOOK_DELETE => 'Delete book',
        };
    }
}
