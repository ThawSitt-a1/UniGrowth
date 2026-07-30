<?php

namespace Database\Factories\Core\Assets\Models;

use App\Core\Assets\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true),
            'tags' => fake()->randomElements(['php', 'laravel', 'javascript', 'python', 'java', 'devops', 'frontend', 'backend', 'database', 'mobile'], rand(1, 3)),
            'description' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'resource_link' => null,
        ];
    }
}
