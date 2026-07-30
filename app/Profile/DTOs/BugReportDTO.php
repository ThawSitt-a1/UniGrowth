<?php

namespace App\Profile\DTOs;

final class BugReportDTO
{
    public function __construct(
        public readonly int $id,
        public readonly int $user_id,
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $steps_to_reproduce,
        public readonly string $severity,
        public readonly ?string $screenshot_path,
        public readonly string $status,
        public readonly string $created_at,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            user_id: $data['user_id'],
            title: $data['title'],
            description: $data['description'],
            steps_to_reproduce: $data['steps_to_reproduce'] ?? null,
            severity: $data['severity'],
            screenshot_path: $data['screenshot_path'] ?? null,
            status: $data['status'],
            created_at: $data['created_at'],
        );
    }
}

