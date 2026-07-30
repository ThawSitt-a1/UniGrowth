<?php

namespace Database\Factories;

use App\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \App\Auth\Models\User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= 'password', // The 'hashed' cast on User model handles hashing automatically
            'remember_token' => Str::random(10),
            'academic_year' => fake()->randomElement(['1st Year', '2nd Year', '3rd Year', '4th Year', 'Graduate']),
            'major' => fake()->randomElement(['Computer Science', 'Business Administration', 'Engineering', 'Mathematics', 'Biology']),
            'university_name' => fake()->company() . ' University',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
