<?php

declare(strict_types=1);

namespace App\Core\Assets\UseCases;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Repositories\AssetRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

final class ManageUserAssetsUseCase
{
    public function __construct(
        private readonly AssetRepositoryInterface $assetRepository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function execute(AssetActionDTO $dto): array
    {
        $user = Auth::guard('web')->user();

        if (! $user instanceof Authenticatable) {
            throw new \RuntimeException('Unauthenticated.');
        }

        if ($user === null) {
            throw new \RuntimeException('Unauthenticated.');
        }

        $userId = (int) $user->getAuthIdentifier();

        $this->assertActionAllowed($dto, $userId);

        return $this->assetRepository->execute($dto, $userId);
    }

    private function assertActionAllowed(AssetActionDTO $dto, int $userId): void
    {
        $type = $dto->type;
        $action = $dto->action;
        $payload = $dto->payload;

        if ($type === 'skill') {
            if ($action === 'enroll') {
                return;
            }

            // users cannot create/delete skills
            abort(403, 'Forbidden action for skills.');
        }

        if ($type === 'goal') {
            if ($action === 'create') {
                $text = trim((string) Arr::get($payload, 'text', ''));
                if ($text === '') {
                    abort(422, 'Goal text is required.');
                }
                return;
            }

            if ($action === 'complete') {
                $goalId = (int) Arr::get($payload, 'goal_id', 0);
                if ($goalId <= 0) {
                    abort(422, 'goal_id is required.');
                }

                // Ensure goal belongs to the user
                // Ownership validation is guaranteed again in repository queries.
                return;
            }

            if ($action === 'delete') {
                $goalId = (int) Arr::get($payload, 'goal_id', 0);
                if ($goalId <= 0) {
                    abort(422, 'goal_id is required.');
                }
                return;
            }

            // Users cannot edit goals (no update action provided)
            abort(403, 'Forbidden action for goals.');
        }

        abort(400, 'Unsupported asset type/action.');
    }
}

