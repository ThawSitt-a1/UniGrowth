<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

use App\Editor\DTOs\QuestionOptionDTO;

interface OptionRepositoryInterface
{
    public function save(QuestionOptionDTO $data): bool;
    public function deleteByOwner(int $id, int $editorId): bool;
    public function verifyOwnership(int $id, int $editorId): bool;
    public function isLockedByAdmin(int $id): bool;
}
