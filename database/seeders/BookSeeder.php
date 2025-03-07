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
        Book::factory()
            ->count(20)
            ->for(Publisher::factory(['password' => env('SEEDER_PUBLISHER_PASSWORD')]))
            ->create();
    }
}
