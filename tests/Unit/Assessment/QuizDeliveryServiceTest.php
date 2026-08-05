<?php

namespace Tests\Unit\Assessment;

use App\Assessment\DTO\QuizPayloadDTO;
use App\Assessment\Models\Question;
use App\Assessment\Models\Option;
use App\Assessment\Models\StudentAnsweredQuestion;
use App\Assessment\Repositories\AssessmentRepository;
use App\Assessment\Services\QuizDeliveryService;
use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizDeliveryServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skill $skill;
    private QuizDeliveryService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->skill = Skill::factory()->create(['title' => 'Test Skill']);

        // Create an active season so QuizDeliveryService can check it
        \App\Overview\Models\Season::query()->create([
            'name' => 'Test Season',
            'started_at' => now()->subDays(10),
            'ends_at' => now()->addDays(10),
            'is_active' => true,
        ]);

        $this->service = $this->app->make(QuizDeliveryService::class);
    }

    /** @test */
    public function it_returns_quiz_payload_dto(): void
    {
        // Create 5 questions (minimum required)
        for ($i = 1; $i <= 5; $i++) {
            $question = Question::query()->create([
                'skill_id' => $this->skill->id,
                'question_text' => "Sample question {$i}?",
                'difficulty' => $i <= 2 ? 'easy' : ($i <= 4 ? 'medium' : 'hard'),
                'is_active' => true,
            ]);
            Option::query()->create(['question_id' => $question->id, 'option_text' => 'A', 'is_correct' => true]);
            Option::query()->create(['question_id' => $question->id, 'option_text' => 'B', 'is_correct' => false]);
        }

        $quiz = $this->service->generateUnseenQuiz((int) $this->user->id, (int) $this->skill->id);

        $this->assertInstanceOf(QuizPayloadDTO::class, $quiz);
        $this->assertEquals($this->skill->id, $quiz->skillId);
        $this->assertEquals('Test Skill', $quiz->skillTitle);
        $this->assertEquals(5, $quiz->totalQuestions);
    }

    /** @test */
    public function it_strips_is_correct_from_options(): void
    {
        // Create 5 questions (minimum required)
        for ($i = 1; $i <= 5; $i++) {
            $question = Question::query()->create([
                'skill_id' => $this->skill->id,
                'question_text' => "Quiz question {$i}?",
                'difficulty' => 'medium',
                'is_active' => true,
            ]);
            Option::query()->create(['question_id' => $question->id, 'option_text' => 'Correct', 'is_correct' => true]);
            Option::query()->create(['question_id' => $question->id, 'option_text' => 'Wrong', 'is_correct' => false]);
        }

        $quiz = $this->service->generateUnseenQuiz((int) $this->user->id, (int) $this->skill->id);

        foreach ($quiz->questions as $q) {
            foreach ($q['options'] as $option) {
                $this->assertArrayNotHasKey('is_correct', $option);
            }
        }
    }

    /** @test */
    public function it_excludes_answered_questions(): void
    {
        // Create 7 questions
        $questions = [];
        for ($i = 1; $i <= 7; $i++) {
            $q = Question::query()->create([
                'skill_id' => $this->skill->id,
                'question_text' => "Q{$i}?",
                'difficulty' => $i <= 2 ? 'easy' : ($i <= 4 ? 'medium' : 'hard'),
                'is_active' => true,
            ]);
            Option::query()->create(['question_id' => $q->id, 'option_text' => 'A', 'is_correct' => true]);
            Option::query()->create(['question_id' => $q->id, 'option_text' => 'B', 'is_correct' => false]);
            $questions[] = $q;
        }

        // Create a real attempt first to satisfy FK constraint
        $attempt = \App\Assessment\Models\Attempt::query()->create([
            'user_id' => $this->user->id,
            'skill_id' => $this->skill->id,
            'score' => 20,
            'max_score' => 20,
            'percentage' => 100,
            'passed' => true,
            'attempted_at' => now(),
        ]);

        // Mark Q1 and Q2 as answered (2 of 7 answered -> 5 remain = exactly 5)
        StudentAnsweredQuestion::query()->create([
            'user_id' => $this->user->id,
            'question_id' => $questions[0]->id,
            'attempt_id' => $attempt->id,
        ]);
        StudentAnsweredQuestion::query()->create([
            'user_id' => $this->user->id,
            'question_id' => $questions[1]->id,
            'attempt_id' => $attempt->id,
        ]);

        $quiz = $this->service->generateUnseenQuiz((int) $this->user->id, (int) $this->skill->id);

        $this->assertEquals(5, $quiz->totalQuestions);

        // Verify none of the returned questions are the answered ones
        $returnedIds = array_map(fn($q) => $q['id'], $quiz->questions);
        $this->assertNotContains((int) $questions[0]->id, $returnedIds);
        $this->assertNotContains((int) $questions[1]->id, $returnedIds);
    }

/** @test */
    public function it_throws_exception_when_no_unseen_questions(): void
    {
        // Create 0 questions - should throw since none available

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'No unseen questions available for this skill. All questions may have been answered already.'
        );

        $this->service->generateUnseenQuiz((int) $this->user->id, (int) $this->skill->id);
    }

    /** @test */
    public function it_returns_exactly_5_randomized_questions(): void
    {
        // Create 10 questions
        for ($i = 1; $i <= 10; $i++) {
            $q = Question::query()->create([
                'skill_id' => $this->skill->id,
                'question_text' => "Random Q{$i}?",
                'difficulty' => $i <= 3 ? 'easy' : ($i <= 6 ? 'medium' : 'hard'),
                'is_active' => true,
            ]);
            Option::query()->create(['question_id' => $q->id, 'option_text' => 'A', 'is_correct' => true]);
            Option::query()->create(['question_id' => $q->id, 'option_text' => 'B', 'is_correct' => false]);
        }

        $quiz = $this->service->generateUnseenQuiz((int) $this->user->id, (int) $this->skill->id);

        $this->assertEquals(5, $quiz->totalQuestions);
        $this->assertCount(5, $quiz->questions);
    }
}

