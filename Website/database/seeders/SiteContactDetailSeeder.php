<?php

namespace Database\Seeders;

use App\Models\SiteContactDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiteContactDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get the admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create or update contact details
        SiteContactDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Your Name',
                'email' => 'your.email@example.com',
                'phone' => '+1234567890',
                'job_title' => 'Full Stack Developer',
                'github_username' => 'yourgithub',
                'x_username' => 'yourtwitter',
                'linkedin_url' => 'https://linkedin.com/in/yourprofile',
                'location' => 'Nairobi, Kenya',
                'address' => "123 Developer Street\nNairobi, 00100",
                'bio' => 'A passionate full-stack developer with expertise in Laravel, Vue.js, and modern web technologies. I love building amazing web applications that solve real-world problems.',
            ]
        );

        $this->command->info('Site contact details seeded successfully!');
    }
}
