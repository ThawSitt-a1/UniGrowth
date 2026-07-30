<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Skill;
use Illuminate\Support\Collection;

/**
 * Skeleton interface — opened for later admin component.
 *
 * @todo Implement full admin skill management.
 */
interface SkillRepositoryInterface
{
    public function create(array $data): Skill;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    /** @return Skill[] */
    public function findAll(): array;

    /**
     * Find skills with optional tag filter and sorting.
     *
     * @return Collection<int, Skill>
     */
    public function findAllFiltered(?string $tag = null, string $sortBy = 'newest'): Collection;

    /**
     * Get all unique tags across all skills.
     *
     * @return string[]
     */
    public function getAllTags(): array;
}
