<?php

namespace App\Front\Publisher\Service;

use App\Common\Helper\EnumToArray;

enum AbilityPublisher: string
{
    use EnumToArray;

    case BOOK_ADD = 'book:add';
    case BOOK_EDIT = 'book:edit';
    case BOOK_DELETE = 'book:delete';
}
