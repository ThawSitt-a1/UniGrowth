<?php

namespace App\Profile\UseCases;

use App\Auth\Models\User;
use App\Profile\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadProfileAssetUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profileRepository,
    ) {}

    public function execute(int $userId, UploadedFile $file): ?string
    {
        $user = User::query()->find($userId);

        if ($user !== null && ! empty($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $file->store('avatars/'.$userId, 'public');

        if ($path === false) {
            return null;
        }

        $this->profileRepository->updateAvatarPath($userId, $path);

        return $path;
    }
}
