<?php

namespace Database\Factories\Common\Models;

use App\Common\Models\Book;
use App\Common\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => fake()->unique()->isbn13(),
            'name' => rtrim(fake()->sentence(), '.'),
            'authors' => fake()->randomElements([
                fake()->name(),
                fake()->name(),
                fake()->name()
            ], fake()->numberBetween(1, 3)),
            'year_publication' => fake()->dateTimeBetween()->format('Y'),
            'detail_link' => 'https://' . fake()->word() . '.com'
        ];
    }
}
