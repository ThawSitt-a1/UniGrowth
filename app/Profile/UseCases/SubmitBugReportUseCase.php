<?php

namespace App\Profile\UseCases;

use App\Profile\Repositories\BugReportRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class SubmitBugReportUseCase
{
    public function __construct(
        private readonly BugReportRepositoryInterface $bugReportRepository,
    ) {
    }

    public function execute(int $userId, array $bugData, ?UploadedFile $screenshot): int
    {
        $attachmentPath = null;

        if ($screenshot !== null) {
            $attachmentPath = $screenshot->store('bug-screenshots/' . $userId, 'public');
        }

        return $this->bugReportRepository->save($userId, $bugData, $attachmentPath);
    }
}

