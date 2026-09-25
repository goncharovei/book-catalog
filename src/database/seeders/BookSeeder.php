<?php

namespace Database\Seeders;

use App\Common\Models\Book;
use App\Common\Models\Publisher;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::all()->each(function (Publisher $publisher){
            Book::factory()
                ->count(fake()->numberBetween(100, 500))
                ->for($publisher)
                ->create();
        });

    }
}
