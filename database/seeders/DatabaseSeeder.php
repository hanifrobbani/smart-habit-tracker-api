<?php

namespace Database\Seeders;

use App\Models\CategoryHabits;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        CategoryHabits::create([
            'name' => 'Health',
        ]);
        CategoryHabits::create([
            'name' => 'Work',
        ]);
        CategoryHabits::create([
            'name' => 'Other',
        ]);
    }
}
