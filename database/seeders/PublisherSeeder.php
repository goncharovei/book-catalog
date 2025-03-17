<?php

namespace Database\Seeders;

use App\Common\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::factory(['password' => env('PUBLISHER_DEFAULT_PASSWORD')])
            ->count(fake()->numberBetween(3, 10))
            ->create();
    }
}
