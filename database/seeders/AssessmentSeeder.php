<?php

namespace Database\Seeders;

use App\Assessment\Models\Option;
use App\Assessment\Models\Question;
use App\Core\Assets\Models\Skill;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Seed questions and options for skills that exist in the database.
     * Generates 5 questions per skill across difficulty levels.
     */
    public function run(): void
    {
        $skills = Skill::all();

        if ($skills->isEmpty()) {
            $this->command->warn('No skills found. Run SkillSeeder first.');
            return;
        }

        foreach ($skills as $skill) {
            $this->seedQuestionsForSkill($skill);
        }
    }

    private function seedQuestionsForSkill(Skill $skill): void
    {
        $difficulties = ['easy', 'easy', 'medium', 'medium', 'hard'];
        $questionIndex = 1;

        foreach ($difficulties as $difficulty) {
            $question = Question::firstOrCreate(
                [
                    'skill_id' => $skill->id,
                    'question_text' => "{$skill->title} - Question {$questionIndex} ({$difficulty})",
                ],
                [
                    'difficulty' => $difficulty,
                    'is_active' => true,
                ]
            );

            // Seed 4 options for each question
            $correctOptionIndex = rand(1, 4);
            for ($optIndex = 1; $optIndex <= 4; $optIndex++) {
                Option::firstOrCreate(
                    [
                        'question_id' => $question->id,
                        'option_text' => "Option {$optIndex} for {$skill->title} Q{$questionIndex}",
                    ],
                    [
                        'is_correct' => $optIndex === $correctOptionIndex,
                    ]
                );
            }

            $questionIndex++;
        }
    }
}

