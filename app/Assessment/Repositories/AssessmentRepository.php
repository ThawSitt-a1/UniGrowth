<?php

declare(strict_types=1);

namespace App\Assessment\Repositories;

use App\Assessment\Models\Attempt;
use App\Assessment\Models\Option;
use App\Assessment\Models\Question;
use App\Assessment\Models\StudentAnsweredQuestion;
use App\Assessment\Models\StudentSkill;
use App\Auth\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class AssessmentRepository implements AssessmentRepositoryInterface
{
    /**
     * Fetch randomized active questions for a skill that the user has NOT answered before.
     * Returns up to 5 questions, but allows as few as 1 question to be available.
     *
     * @return Collection<int, Question>
     * @throws \RuntimeException if no unseen questions are available.
     */
    public function fetchUnseenActiveQuestionsForSkill(int $userId, int $skillId): Collection
    {
        $answeredQuestionIds = StudentAnsweredQuestion::query()
            ->where('user_id', $userId)
            ->pluck('question_id')
            ->toArray();

        $query = Question::query()
            ->where('skill_id', $skillId)
            ->where('is_active', true);

        if (!empty($answeredQuestionIds)) {
            $query->whereNotIn('id', $answeredQuestionIds);
        }

        $questions = $query->inRandomOrder()->take(5)->with('options')->get();

        if ($questions->count() < 1) {
            throw new \RuntimeException(
                'No unseen questions available for this skill. All questions may have been answered already.'
            );
        }

        return $questions;
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function fetchCorrectOptions(array $questionIds): array
    {
        $correctOptions = Option::query()
            ->whereIn('question_id', $questionIds)
            ->where('is_correct', true)
            ->get();

        $result = [];
        foreach ($correctOptions as $option) {
            $result[$option->question_id][] = $option->id;
        }

        return $result;
    }

    public function logAttemptAndAnsweredQuestions(
        int $userId,
        array $attemptData,
        array $answeredQuestionIds,
    ): Attempt {
        return DB::transaction(function () use ($userId, $attemptData, $answeredQuestionIds): Attempt {
            $attempt = Attempt::query()->create($attemptData);

            $records = [];
            foreach ($answeredQuestionIds as $questionId => $selectedOptionId) {
                $records[] = [
                    'user_id' => $userId,
                    'question_id' => $questionId,
                    'attempt_id' => $attempt->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            StudentAnsweredQuestion::query()->insert($records);

            return $attempt;
        });
    }

public function upsertStudentSkillProficiency(int $userId, int $skillId, float $score): void
    {
        $record = StudentSkill::query()->firstOrNew(
            ['user_id' => $userId, 'skill_id' => $skillId]
        );

        $record->proficiency_score = $score;
        $record->attempts_count = ($record->attempts_count ?? 0) + 1;
        $record->last_attempted_at = now();
        $record->save();
    }

    public function updateUserPlatformScore(int $userId): void
    {
        $totalScore = StudentSkill::query()
            ->where('user_id', $userId)
            ->sum('proficiency_score');

        User::query()->where('id', $userId)->update([
            'platform_score' => $totalScore,
        ]);
    }

/**
     * @return Collection<int, User>
     */
    public function fetchLeaderboardData(): Collection
    {
        return User::query()
            ->orderBy('platform_score', 'desc')
            ->limit(50)
->get(['id', 'username', 'platform_score', 'preferences'])
            ->filter(fn (User $user) => !$this->isHiddenFromLeaderboards($user))
->take(10)
            ->values();
    }

    /**
     * Determine whether a user should be excluded from public leaderboards.
     *
     * A user is hidden if they have enabled "Make my profile private"
     * (`make_profile_private`), or if they previously toggled the legacy
     * "Hide from leaderboards" preference (`privacy_hide_leaderboards`).
     */
    private function isHiddenFromLeaderboards(User $user): bool
    {
        $preferences = $user->preferences ?? [];

        return (bool) ($preferences['make_profile_private'] ?? false)
            || (bool) ($preferences['privacy_hide_leaderboards'] ?? false);
    }

    /**
     * @return array{total_skills: int, total_attempts: int, average_score: float, total_questions_answered: int}
     */
    public function fetchDashboardStats(int $userId): array
    {
        $totalSkills = StudentSkill::query()
            ->where('user_id', $userId)
            ->count();

        $totalAttempts = Attempt::query()
            ->where('user_id', $userId)
            ->count();

        $averageScore = Attempt::query()
            ->where('user_id', $userId)
            ->avg('percentage') ?? 0.0;

        $totalQuestionsAnswered = StudentAnsweredQuestion::query()
            ->where('user_id', $userId)
            ->count();

        return [
            'total_skills' => $totalSkills,
            'total_attempts' => $totalAttempts,
            'average_score' => round((float) $averageScore, 2),
            'total_questions_answered' => $totalQuestionsAnswered,
        ];
    }

    /**
     * @return Collection<int, StudentSkill>
     */
    public function fetchStudentSkills(int $userId): Collection
    {
        return StudentSkill::query()
            ->where('user_id', $userId)
            ->with('skill')
            ->orderBy('proficiency_score', 'desc')
            ->get();
    }
}

