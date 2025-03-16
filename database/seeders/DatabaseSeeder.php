<?php

namespace Database\Seeders;

use App\Common\Models\Publisher;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Publisher::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => env('PUBLISHER_DEFAULT_PASSWORD')
        ]);
    }
}
