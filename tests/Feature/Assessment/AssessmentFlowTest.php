<?php

namespace Tests\Feature\Assessment;

use App\Assessment\Models\Attempt;
use App\Assessment\Models\Question;
use App\Assessment\Models\Option;
use App\Assessment\Models\StudentAnsweredQuestion;
use App\Assessment\Models\StudentSkill;
use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skill $skill;
    private array $questions = [];

    protected function setUp(): void
    {
        parent::setUp();

        // Create an active season so the assessment flow works through season gating
        \App\Overview\Models\Season::query()->create([
            'name' => 'Test Season',
            'started_at' => now()->subDays(10),
            'ends_at' => now()->addDays(10),
            'is_active' => true,
        ]);

        // Create user
        $this->user = User::factory()->create([
            'platform_score' => 0,
        ]);

        // Create a skill
        $this->skill = Skill::factory()->create([
            'title' => 'Test Skill',
            'tags' => ['test', 'php'],
        ]);

        // Create 6 questions with 4 options each (need at least 6 so after answering 5, 1 remains)
        for ($i = 1; $i <= 6; $i++) {
            $question = Question::query()->create([
                'skill_id' => $this->skill->id,
                'question_text' => "Test Question {$i}",
                'difficulty' => $i <= 2 ? 'easy' : ($i <= 4 ? 'medium' : 'hard'),
                'is_active' => true,
            ]);

            $correctOptionIndex = rand(1, 4);
            for ($j = 1; $j <= 4; $j++) {
                Option::query()->create([
                    'question_id' => $question->id,
                    'option_text' => "Option {$j} for Q{$i}",
                    'is_correct' => $j === $correctOptionIndex,
                ]);
            }

            $this->questions[] = $question;
        }
    }

    /** @test */
    public function it_can_fetch_unseen_quiz_for_authenticated_user(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/skills/{$this->skill->id}/quiz");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'skill_id',
                    'skill_title',
                    'total_questions',
                    'questions' => [
                        '*' => [
                            'id',
                            'question_text',
                            'difficulty',
                            'options' => [
                                '*' => ['id', 'option_text'],
                            ],
                        ],
                    ],
                ],
            ]);

        // Verify that exactly 5 questions are returned
        $responseData = $response->json('data');
        $this->assertEquals(5, $responseData['total_questions']);
        $this->assertCount(5, $responseData['questions']);
        foreach ($responseData['questions'] as $question) {
            foreach ($question['options'] as $option) {
                $this->assertArrayNotHasKey('is_correct', $option);
            }
        }
    }

    /** @test */
    public function it_serves_exactly_5_randomized_questions(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/skills/{$this->skill->id}/quiz");

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $this->assertEquals(5, $responseData['total_questions']);
        $this->assertCount(5, $responseData['questions']);
    }

    /** @test */
    public function it_returns_error_when_less_than_5_unseen_questions_exist(): void
    {
        // Create a second skill with only 3 questions
        $smallSkill = Skill::factory()->create([
            'title' => 'Small Skill',
            'tags' => ['test'],
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $question = Question::query()->create([
                'skill_id' => $smallSkill->id,
                'question_text' => "Small Q{$i}",
                'difficulty' => 'easy',
                'is_active' => true,
            ]);
            Option::query()->create([
                'question_id' => $question->id,
                'option_text' => "Option A for SQ{$i}",
                'is_correct' => true,
            ]);
            Option::query()->create([
                'question_id' => $question->id,
                'option_text' => "Option B for SQ{$i}",
                'is_correct' => false,
            ]);
        }

        $response = $this->actingAs($this->user)
            ->getJson("/api/skills/{$smallSkill->id}/quiz");

        $response->assertStatus(422);
        $response->assertJson([
            'error' => 'Not enough unseen questions available for this skill. A minimum of 5 questions is required to generate a quiz.',
        ]);
    }

    /** @test */
    public function it_requires_authentication_for_quiz(): void
    {
        $response = $this->getJson("/api/skills/{$this->skill->id}/quiz");
        $response->assertStatus(401);
    }

    /** @test */
    public function it_can_submit_quiz_and_get_results(): void
    {
        // Submit answers for 5 questions (using first 5 of the 6)
        $firstFiveQuestions = array_slice($this->questions, 0, 5);
        $correctAnswers = [];
        foreach ($firstFiveQuestions as $question) {
            $correctOption = Option::query()
                ->where('question_id', $question->id)
                ->where('is_correct', true)
                ->first();
            $correctAnswers[] = [
                'question_id' => $question->id,
                'selected_option_id' => $correctOption->id,
            ];
        }

        $response = $this->actingAs($this->user)
            ->postJson("/api/skills/{$this->skill->id}/submit", [
                'answers' => $correctAnswers,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'attempt_id',
                    'skill_id',
                    'skill_title',
                    'score',
                    'max_score',
                    'percentage',
                    'passed',
                    'question_results',
                    'proficiency_score',
                ],
            ]);

        $responseData = $response->json('data');
        $this->assertTrue($responseData['passed']);
        $this->assertEquals(50.0, $responseData['score']); // 5 questions * 10 points
        $this->assertEquals(100.0, $responseData['percentage']);

        // Verify attempt was logged
        $this->assertDatabaseHas('attempts', [
            'user_id' => $this->user->id,
            'skill_id' => $this->skill->id,
            'passed' => true,
        ]);

        // Verify answered questions were logged (5 questions)
        foreach ($firstFiveQuestions as $question) {
            $this->assertDatabaseHas('student_answered_questions', [
                'user_id' => $this->user->id,
                'question_id' => $question->id,
            ]);
        }

        // Verify student skill was created
        $this->assertDatabaseHas('student_skills', [
            'user_id' => $this->user->id,
            'skill_id' => $this->skill->id,
        ]);

        // Verify platform score was updated
        $this->user->refresh();
        $this->assertGreaterThan(0, $this->user->platform_score);
    }

    /** @test */
    public function it_prevents_question_repetition(): void
    {
        // Answer 5 questions first
        $firstFiveQuestions = array_slice($this->questions, 0, 5);
        $correctAnswers = [];
        foreach ($firstFiveQuestions as $question) {
            $correctOption = Option::query()
                ->where('question_id', $question->id)
                ->where('is_correct', true)
                ->first();
            $correctAnswers[] = [
                'question_id' => $question->id,
                'selected_option_id' => $correctOption->id,
            ];
        }

        $this->actingAs($this->user)
            ->postJson("/api/skills/{$this->skill->id}/submit", [
                'answers' => $correctAnswers,
            ]);

        // Second quiz should have exactly 1 unseen question (the 6th one)
        $response = $this->actingAs($this->user)
            ->getJson("/api/skills/{$this->skill->id}/quiz");

        $response->assertStatus(422);
        $response->assertJson([
            'error' => 'Not enough unseen questions available for this skill. A minimum of 5 questions is required to generate a quiz.',
        ]);
    }

    /** @test */
    public function it_serves_new_random_set_after_previous_quiz(): void
    {
        // Create 10 questions for a fresh skill
        $bigSkill = Skill::factory()->create([
            'title' => 'Big Skill',
            'tags' => ['test', 'php'],
        ]);

        $bigQuestions = [];
        for ($i = 1; $i <= 10; $i++) {
            $question = Question::query()->create([
                'skill_id' => $bigSkill->id,
                'question_text' => "Big Question {$i}",
                'difficulty' => $i <= 3 ? 'easy' : ($i <= 6 ? 'medium' : 'hard'),
                'is_active' => true,
            ]);
            Option::query()->create([
                'question_id' => $question->id,
                'option_text' => "Correct for Q{$i}",
                'is_correct' => true,
            ]);
            Option::query()->create([
                'question_id' => $question->id,
                'option_text' => "Wrong for Q{$i}",
                'is_correct' => false,
            ]);
            $bigQuestions[] = $question;
        }

        // Get first set of 5 questions
        $firstResponse = $this->actingAs($this->user)
            ->getJson("/api/skills/{$bigSkill->id}/quiz");

        $firstResponse->assertStatus(200);
        $firstSet = $firstResponse->json('data.questions');
        $this->assertCount(5, $firstSet);
        $firstIds = array_map(fn($q) => $q['id'], $firstSet);

        // Submit answers for those 5 questions
        $answers = [];
        foreach ($firstSet as $q) {
            $correctOption = Option::query()
                ->where('question_id', $q['id'])
                ->where('is_correct', true)
                ->first();
            $answers[] = [
                'question_id' => $q['id'],
                'selected_option_id' => $correctOption->id,
            ];
        }

        $this->actingAs($this->user)
            ->postJson("/api/skills/{$bigSkill->id}/submit", [
                'answers' => $answers,
            ]);

        // Get second set of 5 questions (should be different from first)
        $secondResponse = $this->actingAs($this->user)
            ->getJson("/api/skills/{$bigSkill->id}/quiz");

        $secondResponse->assertStatus(200);
        $secondSet = $secondResponse->json('data.questions');
        $this->assertCount(5, $secondSet);
        $secondIds = array_map(fn($q) => $q['id'], $secondSet);

        // Ensure none of the second set IDs appear in the first set (no repetition)
        foreach ($secondIds as $id) {
            $this->assertNotContains($id, $firstIds);
        }
    }

    /** @test */
    public function it_can_fetch_dashboard_metrics(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/api/dashboard/{$this->user->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'student_id',
                    'username',
                    'platform_score',
                    'rank',
                    'stats' => [
                        'total_skills',
                        'total_attempts',
                        'average_score',
                        'total_questions_answered',
                    ],
                    'skill_progress',
                ],
            ]);
    }

/** @test */
    public function it_can_fetch_leaderboard(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/leaderboard');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['rank', 'user_id', 'username', 'platform_score'],
                ],
                'meta' => ['total'],
            ]);
    }

    /** @test */
    public function it_excludes_users_hiding_from_leaderboards(): void
    {
        // Give the authenticated user a high score so they appear on the board.
        $this->user->update(['platform_score' => 100]);

// Create a user who opted out of leaderboards (via "Make my profile private"),
        // with a higher score.
        $hiddenUser = User::factory()->create([
            'platform_score' => 200,
            'preferences' => ['make_profile_private' => true],
        ]);

        // Create a normal user with a lower score.
        $visibleUser = User::factory()->create([
            'platform_score' => 50,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/leaderboard');

        $response->assertStatus(200)
            ->assertJsonMissing([
                'data' => [
                    ['user_id' => $hiddenUser->id],
                ],
            ]);

        $userIds = collect($response->json('data'))->pluck('user_id');
        $this->assertNotContains($hiddenUser->id, $userIds->all());
        $this->assertContains($visibleUser->id, $userIds->all());
        $this->assertContains($this->user->id, $userIds->all());
    }

    /** @test */
    public function it_excludes_hidden_users_from_season_leaderboard(): void
    {
        $season = \App\Overview\Models\Season::query()->get()->first();

// A user who opted out of leaderboards (via "Make my profile private").
        $hiddenUser = User::factory()->create([
            'preferences' => ['make_profile_private' => true],
        ]);

        // A visible user.
        $visibleUser = User::factory()->create();

        \App\Overview\Models\SeasonScore::query()->create([
            'user_id' => $hiddenUser->id,
            'season_id' => $season->id,
            'total_score' => 200,
            'skill_count' => 1,
            'total_questions_answered' => 10,
            'total_attempts' => 1,
            'last_active_at' => now(),
        ]);

        \App\Overview\Models\SeasonScore::query()->create([
            'user_id' => $visibleUser->id,
            'season_id' => $season->id,
            'total_score' => 100,
            'skill_count' => 1,
            'total_questions_answered' => 10,
            'total_attempts' => 1,
            'last_active_at' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/seasons/{$season->id}/leaderboard");

        $response->assertStatus(200);

        $userIds = collect($response->json('data'))->pluck('user_id');
        $this->assertNotContains($hiddenUser->id, $userIds->all());
        $this->assertContains($visibleUser->id, $userIds->all());
    }

    /** @test */
    public function it_returns_404_for_nonexistent_skill(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson('/api/skills/99999/quiz');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_validates_quiz_submission(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson("/api/skills/{$this->skill->id}/submit", [
                'answers' => [],
            ]);

        $response->assertStatus(422);
    }
}

