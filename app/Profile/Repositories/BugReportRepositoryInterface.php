<?php

namespace App\Profile\Repositories;

interface BugReportRepositoryInterface
{
    public function save(int $userId, array $data, ?string $attachmentPath): int;
}

