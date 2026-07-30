<?php

namespace Database\Seeders;

use App\Auth\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin account
        User::create([
            'username' => 'admin11',
            'email' => 'admin11@unigrowth.com',
            'password' => 'Admin1123!',
            'role' => User::ROLE_ADMIN,
            'account_status' => 'allowed',
            'email_verified_at' => now(),
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'testuser1',
            'email' => 'test1@example.com',
            'password' => 'test123!'
        ]);

        // Seed skills for core assets testing frontend
        $this->call(SkillSeeder::class);

        // Seed questions and options for skill assessment testing
        $this->call(AssessmentSeeder::class);
    }
}
