<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

use App\Editor\DTOs\ContentQueryFilterDTO;

interface EditorContentRepositoryInterface
{
    public function fetchFiltered(ContentQueryFilterDTO $filters): array;
}
