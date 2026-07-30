<?php

namespace App\Profile\Repositories;

use App\Profile\Models\BugReport;

final class BugReportRepository implements BugReportRepositoryInterface
{
    public function save(int $userId, array $data, ?string $attachmentPath): int
    {
        $report = BugReport::query()->create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'steps_to_reproduce' => $data['steps_to_reproduce'] ?? null,
            'severity' => $data['severity'] ?? 'medium',
            'screenshot_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return $report->id;
    }
}

