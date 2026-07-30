<?php

namespace App\Profile\UseCases;

use App\Profile\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadProfileAssetUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profileRepository,
    ) {
    }

    public function execute(int $userId, UploadedFile $file): ?string
    {
        $path = $file->store('avatars/' . $userId, 'public');

        if ($path === false) {
            return null;
        }

        // Store the relative path (e.g. 'avatars/1/abc.jpg')
        // Views use: asset('storage/' . $avatar_path) which resolves correctly
        $this->profileRepository->updateAvatarPath($userId, $path);

        return $path;
    }
}

