<?php

namespace App\Profile\UseCases;

use App\Profile\Repositories\ProfileRepositoryInterface;

final class GenerateReportUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profileRepository,
    ) {
    }

    public function execute(int $userId, string $reportType): ?array
    {
        $profileData = $this->profileRepository->findByUserId($userId);

        if ($profileData === null) {
            return null;
        }

        // Build report data based on type
        $report = match ($reportType) {
            'transcript' => $this->buildTranscript($profileData),
            'summary' => $this->buildSummary($profileData),
            default => $this->buildSummary($profileData),
        };

        return $report;
    }

    private function buildTranscript(array $profileData): array
    {
        return [
            'type' => 'transcript',
            'generated_at' => now()->toDateTimeString(),
            'user' => [
                'username' => $profileData['username'],
                'email' => $profileData['email'],
                'academic_year' => $profileData['academic_year'],
                'major' => $profileData['major'],
                'university_name' => $profileData['university_name'],
                'platform_score' => $profileData['platform_score'],
            ],
            'sections' => [
                'profile' => $profileData,
            ],
        ];
    }

    private function buildSummary(array $profileData): array
    {
        return [
            'type' => 'summary',
            'generated_at' => now()->toDateTimeString(),
            'username' => $profileData['username'],
            'academic_year' => $profileData['academic_year'],
            'major' => $profileData['major'],
            'university_name' => $profileData['university_name'],
            'platform_score' => $profileData['platform_score'],
        ];
    }
}

