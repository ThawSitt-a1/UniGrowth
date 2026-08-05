<?php

namespace App\Livewire;

use App\Profile\UseCases\ManageProfileUseCase;
use App\Profile\UseCases\UploadProfileAssetUseCase;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileUpdateManager extends Component
{
    use WithFileUploads;

    /** @var \Livewire\TemporaryUploadedFile|null */
    public $profile_photo = null;

    public string $username = '';
    public string $major = '';
    public string $academic_year = '';
    public string $university_name = '';
    public string $description = '';

    public bool $photo_preview_visible = false;
    public string $photo_preview_url = '';

    protected function rules(): array
    {
        return [
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash'],
            'major' => ['nullable', 'string', 'max:100'],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'university_name' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'profile_photo.max' => 'Profile picture size must not exceed 2MB.',
            'profile_photo.mimes' => 'Profile picture must be a JPG or PNG file.',
            'username.required' => 'Username is required.',
            'username.alpha_dash' => 'Username may only contain letters, numbers, dashes, and underscores.',
            'username.max' => 'Username cannot exceed 50 characters.',
        ];
    }

    public function mount(): void
    {
        $user = auth()->user();
        $this->username = $user->username ?? '';
        $this->major = $user->major ?? '';
        $this->academic_year = $user->academic_year ?? '';
        $this->university_name = $user->university_name ?? '';
        $this->description = $user->description ?? '';
    }

    public function updatedProfilePhoto(): void
    {
        $this->validateOnly('profile_photo');

        $this->photo_preview_visible = true;
        $this->photo_preview_url = $this->profile_photo->temporaryUrl();
    }

    public function save(): void
    {
        $this->validate();

        $userId = auth()->id();

        // Resolve use cases from container
        $manageProfileUseCase = app(ManageProfileUseCase::class);
        $uploadProfileAssetUseCase = app(UploadProfileAssetUseCase::class);

        // Upload profile photo if provided
        if ($this->profile_photo) {
            $uploadProfileAssetUseCase->execute($userId, $this->profile_photo);
        }

        // Update profile data
        $manageProfileUseCase->updateProfile($userId, [
            'username' => $this->username,
            'major' => $this->major,
            'academic_year' => $this->academic_year,
            'university_name' => $this->university_name,
            'description' => $this->description,
        ]);

        $this->dispatch('profile-updated', message: 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile-update-manager');
    }
}
