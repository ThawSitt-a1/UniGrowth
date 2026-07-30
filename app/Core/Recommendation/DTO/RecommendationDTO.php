<?php

declare(strict_types=1);

namespace App\Core\Recommendation\DTO;

final class RecommendationDTO
{
    public function __construct(
        public readonly int $skill_id,
        public readonly string $title,
        public readonly string $description,
        /** @var string[] */
        public readonly array $tags,
        public readonly int $matching_tags_count,
        /** @var string[] */
        public readonly array $matching_tags,
        public readonly float $score,
        public readonly ?string $resource_link = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'skill_id' => $this->skill_id,
            'title' => $this->title,
            'description' => $this->description,
            'tags' => $this->tags,
            'matching_tags_count' => $this->matching_tags_count,
            'matching_tags' => $this->matching_tags,
            'score' => $this->score,
            'resource_link' => $this->resource_link,
        ];
    }
}
