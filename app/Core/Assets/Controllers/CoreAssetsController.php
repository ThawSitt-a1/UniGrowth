<?php

declare(strict_types=1);

namespace App\Core\Assets\Controllers;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\UseCases\ManageUserAssetsUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CoreAssetsController extends Controller
{
    public function __construct(
        private readonly ManageUserAssetsUseCase $manageUserAssetsUseCase,
    ) {
    }

    public function act(Request $request): JsonResponse
    {
        $dto = new AssetActionDTO(
            type: (string) $request->input('type'),
            action: (string) $request->input('action'),
            payload: (array) $request->input('payload', []),
        );

        $result = $this->manageUserAssetsUseCase->execute($dto);

        return response()->json($result);
    }
}


