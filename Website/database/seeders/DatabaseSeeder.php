<?php

namespace Database\Seeders;

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
        // Don't create random users in production
        if (app()->environment('local')) {
            \App\Models\User::factory(10)->create();
        }

        $this->call([
            AdminUserSeeder::class,
            SiteContactDetailSeeder::class,
            // Add other seeders here as needed, but not MediaSeeder
        ]);
    }
}
