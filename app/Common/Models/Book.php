<?php

namespace App\Common\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Book
 * @package App\Common\Models
 *
 * @property int $id
 * @property int $publisher_id
 * @property string $isbn
 * @property string $name
 * @property array $authors
 * @property int $year_publication
 * @property string $detail_link
 * @property Publisher $publisher
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'name',
        'authors',
        'year_publication',
        'detail_link'
    ];

    protected function casts(): array
    {
        return [
            'authors' => 'array',
        ];
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

}
