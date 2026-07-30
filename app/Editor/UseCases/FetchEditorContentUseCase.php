<?php

declare(strict_types=1);

namespace App\Editor\UseCases;

use App\Editor\DTOs\ContentQueryFilterDTO;
use App\Editor\Repositories\EditorContentRepositoryInterface;

final class FetchEditorContentUseCase
{
    public function __construct(
        private readonly EditorContentRepositoryInterface $contentRepository,
    ) {
    }

    public function execute(ContentQueryFilterDTO $filters): array
    {
        return $this->contentRepository->fetchFiltered($filters);
    }
}
