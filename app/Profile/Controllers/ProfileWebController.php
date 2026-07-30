<?php

namespace App\Profile\Controllers;

use App\Profile\Http\Requests\UpdateProfileRequest;
use App\Profile\Http\Requests\UpdatePreferencesRequest;
use App\Profile\Http\Requests\UploadAvatarRequest;
use App\Profile\Http\Requests\UpdatePrivacySocialRequest;
use App\Profile\Http\Requests\BugReportRequest;
use App\Profile\Http\Requests\UpdateAccountRequest;
use App\Profile\UseCases\ManageProfileUseCase;
use App\Profile\UseCases\UpdatePreferencesUseCase;
use App\Profile\UseCases\UploadProfileAssetUseCase;
use App\Profile\UseCases\ManagePrivacyAndSocialUseCase;
use App\Profile\UseCases\GenerateReportUseCase;
use App\Profile\UseCases\SubmitBugReportUseCase;
use App\Profile\UseCases\UpdateAccountUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileWebController
{
    public function __construct(
        private readonly ManageProfileUseCase $manageProfileUseCase,
        private readonly UpdatePreferencesUseCase $updatePreferencesUseCase,
        private readonly UploadProfileAssetUseCase $uploadProfileAssetUseCase,
        private readonly ManagePrivacyAndSocialUseCase $managePrivacyAndSocialUseCase,
        private readonly GenerateReportUseCase $generateReportUseCase,
        private readonly SubmitBugReportUseCase $submitBugReportUseCase,
        private readonly UpdateAccountUseCase $updateAccountUseCase,
    ) {
    }

    /**
     * Show the profile page.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $profile = $this->manageProfileUseCase->getProfile($request->user()->id);

        if ($profile === null) {
            return redirect()->route('dashboard')->with('error', 'Profile not found.');
        }

        return view('profile.index', ['profile' => $profile->toArray()]);
    }

    /**
     * Show the edit profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $profile = $this->manageProfileUseCase->getProfile($request->user()->id);

        if ($profile === null) {
            return redirect()->route('dashboard')->with('error', 'Profile not found.');
        }

        return view('profile.edit', ['profile' => $profile->toArray()]);
    }

    /**
     * Update profile biographical data.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $updated = $this->manageProfileUseCase->updateProfile(
            $request->user()->id,
            $request->validated()
        );

        if (!$updated) {
            return redirect()->route('profile.edit')
                ->with('error', 'No changes were made to your profile.');
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update user preferences (theme, notifications, privacy).
     */
    public function updatePreferences(UpdatePreferencesRequest $request): RedirectResponse
    {
        $this->updatePreferencesUseCase->execute(
            $request->user()->id,
            $request->validated()
        );

        return redirect()->route('profile.show')
            ->with('success', 'Preferences updated successfully.');
    }

    /**
     * Upload profile avatar.
     */
    public function uploadAvatar(UploadAvatarRequest $request): RedirectResponse
    {
        $path = $this->uploadProfileAssetUseCase->execute(
            $request->user()->id,
            $request->file('avatar')
        );

        if ($path === null) {
            return redirect()->route('profile.edit')
                ->with('error', 'Failed to upload avatar. Please try again.');
        }

        return redirect()->route('profile.show')
            ->with('success', 'Avatar updated successfully.');
    }

    /**
     * Update privacy and social links.
     */
    public function updatePrivacySocial(UpdatePrivacySocialRequest $request): RedirectResponse
    {
        $this->managePrivacyAndSocialUseCase->execute(
            $request->user()->id,
            $request->string('visibility')->toString(),
            $request->input('social_links', [])
        );

        return redirect()->route('profile.show')
            ->with('success', 'Privacy and social settings updated successfully.');
    }

    /**
     * Download a profile report.
     */
    public function downloadReport(Request $request): RedirectResponse
    {
        $reportType = $request->query('type', 'summary');
        $report = $this->generateReportUseCase->execute($request->user()->id, $reportType);

        if ($report === null) {
            return redirect()->route('profile.show')
                ->with('error', 'Failed to generate report.');
        }

        // Return as JSON download for simplicity
        return response()->json($report)
            ->header('Content-Disposition', 'attachment; filename="profile-report.json"');
    }

    /**
     * Submit a bug report.
     */
    public function submitBugReport(BugReportRequest $request): RedirectResponse
    {
        $this->submitBugReportUseCase->execute(
            $request->user()->id,
            $request->safe()->except('screenshot'),
            $request->file('screenshot')
        );

        return redirect()->route('profile.show')
            ->with('success', 'Bug report submitted successfully. Thank you for your feedback!');
    }

    /**
     * Show the bug report form.
     */
    public function showBugReportForm(): View
    {
        return view('profile.bug-report');
    }

    /**
     * Show the security settings page.
     */
    public function showSecurity(Request $request): View|RedirectResponse
    {
        $profile = $this->manageProfileUseCase->getProfile($request->user()->id);

        if ($profile === null) {
            return redirect()->route('dashboard')->with('error', 'Profile not found.');
        }

        return view('profile.security', ['profile' => $profile->toArray()]);
    }

    /**
     * Change password or deactivate account.
     */
    public function updateAccount(UpdateAccountRequest $request): RedirectResponse
    {
        $action = $request->string('action')->toString();
        $userId = $request->user()->id;

        return match ($action) {
            'change_password' => $this->handleChangePassword($request, $userId),
            'deactivate' => $this->handleDeactivate($userId),
            default => redirect()->route('profile.security')
                ->with('error', 'Invalid action.'),
        };
    }

    private function handleChangePassword(UpdateAccountRequest $request, int $userId): RedirectResponse
    {
        $this->updateAccountUseCase->changePassword(
            $userId,
            $request->string('new_password')->toString()
        );

        return redirect()->route('profile.security')
            ->with('success', 'Password changed successfully.');
    }

    private function handleDeactivate(int $userId): RedirectResponse
    {
        $this->updateAccountUseCase->deactivateAccount($userId);

        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Your account has been deactivated. Contact support to reactivate.');
    }
}

