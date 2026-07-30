<?php

namespace Tests\Unit\Assessment;

use App\Assessment\DTO\AssessmentResultDTO;
use App\Assessment\Models\Attempt;
use App\Assessment\Models\Question;
use App\Assessment\Models\Option;
use App\Assessment\Models\StudentAnsweredQuestion;
use App\Assessment\Models\StudentSkill;
use App\Assessment\Repositories\AssessmentRepository;
use App\Assessment\Services\RankingAggregatorService;
use App\Assessment\UseCases\EvaluateQuizUseCase;
use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluateQuizUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skill $skill;
    private EvaluateQuizUseCase $useCase;
    private array $questions = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->skill = Skill::factory()->create(['title' => 'PHP']);

        // Create an active season so EvaluateQuizUseCase can record season scores
        \App\Overview\Models\Season::query()->create([
            'name' => 'Test Season',
            'started_at' => now()->subDays(10),
            'ends_at' => now()->addDays(10),
            'is_active' => true,
        ]);

        // Create 2 questions
        for ($i = 1; $i <= 2; $i++) {
            $question = Question::query()->create([
                'skill_id' => $this->skill->id,
                'question_text' => "Q{$i}",
                'difficulty' => $i === 1 ? 'easy' : 'hard',
                'is_active' => true,
            ]);

            // Option 1 is correct
            Option::query()->create(['question_id' => $question->id, 'option_text' => 'Correct', 'is_correct' => true]);
            Option::query()->create(['question_id' => $question->id, 'option_text' => 'Wrong', 'is_correct' => false]);

            $this->questions[] = $question;
        }

        $this->useCase = $this->app->make(EvaluateQuizUseCase::class);
    }

    /** @test */
    public function it_returns_assessment_result_dto(): void
    {
        $correctOption1 = Option::query()->where('question_id', $this->questions[0]->id)->where('is_correct', true)->first();
        $correctOption2 = Option::query()->where('question_id', $this->questions[1]->id)->where('is_correct', true)->first();

        $answers = [
            ['question_id' => $this->questions[0]->id, 'selected_option_id' => $correctOption1->id],
            ['question_id' => $this->questions[1]->id, 'selected_option_id' => $correctOption2->id],
        ];

        $result = $this->useCase->execute((int) $this->user->id, (int) $this->skill->id, $answers);

        $this->assertInstanceOf(AssessmentResultDTO::class, $result);
        $this->assertEquals(20.0, $result->score);
        $this->assertEquals(100.0, $result->percentage);
        $this->assertTrue($result->passed);
    }

    /** @test */
    public function it_handles_failing_score(): void
    {
        $wrongOption1 = Option::query()->where('question_id', $this->questions[0]->id)->where('is_correct', false)->first();
        $wrongOption2 = Option::query()->where('question_id', $this->questions[1]->id)->where('is_correct', false)->first();

        $answers = [
            ['question_id' => $this->questions[0]->id, 'selected_option_id' => $wrongOption1->id],
            ['question_id' => $this->questions[1]->id, 'selected_option_id' => $wrongOption2->id],
        ];

        $result = $this->useCase->execute((int) $this->user->id, (int) $this->skill->id, $answers);

        $this->assertEquals(0.0, $result->score);
        $this->assertEquals(0.0, $result->percentage);
        $this->assertFalse($result->passed);
    }

    /** @test */
    public function it_persists_attempt_and_answered_questions(): void
    {
        $correctOption = Option::query()->where('question_id', $this->questions[0]->id)->where('is_correct', true)->first();
        $wrongOption = Option::query()->where('question_id', $this->questions[1]->id)->where('is_correct', false)->first();

        $answers = [
            ['question_id' => $this->questions[0]->id, 'selected_option_id' => $correctOption->id],
            ['question_id' => $this->questions[1]->id, 'selected_option_id' => $wrongOption->id],
        ];

        $this->useCase->execute((int) $this->user->id, (int) $this->skill->id, $answers);

        $this->assertDatabaseHas('attempts', [
            'user_id' => $this->user->id,
            'skill_id' => $this->skill->id,
            'score' => 10.0,
            'max_score' => 20.0,
            'percentage' => 50.0,
            'passed' => false,
        ]);

        $this->assertDatabaseHas('student_answered_questions', [
            'user_id' => $this->user->id,
            'question_id' => $this->questions[0]->id,
        ]);

        $this->assertDatabaseHas('student_skills', [
            'user_id' => $this->user->id,
            'skill_id' => $this->skill->id,
        ]);
    }
}
