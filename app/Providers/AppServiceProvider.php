<?php

namespace App\Providers;

use App\Admin\Repositories\ContentRepository;
use App\Admin\Repositories\ContentRepositoryInterface;
use App\Admin\Repositories\MetricsRepository;
use App\Admin\Repositories\MetricsRepositoryInterface;
use App\Admin\Repositories\SettingsRepository;
use App\Admin\Repositories\SettingsRepositoryInterface;
use App\Admin\Services\SystemSettingsService;
use App\Admin\Services\SystemSettingsServiceInterface;
use App\Assessment\Repositories\AssessmentRepository;
use App\Assessment\Repositories\AssessmentRepositoryInterface;
use App\Auth\Repositories\EloquentUserRepository;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Core\Assets\Repositories\EnrollmentRepository;
use App\Core\Assets\Repositories\EnrollmentRepositoryInterface;
use App\Core\Assets\Repositories\GoalRepository;
use App\Core\Assets\Repositories\GoalRepositoryInterface;
use App\Core\Assets\Repositories\HabitRepository;
use App\Core\Assets\Repositories\HabitRepositoryInterface;
use App\Core\Assets\Repositories\UserRepository;
use App\Core\Recommendation\Repositories\TagRepository;
use App\Core\Recommendation\Repositories\TagRepositoryInterface;
use App\Editor\Repositories\EditorContentRepository;
use App\Editor\Repositories\EditorContentRepositoryInterface;
use App\Editor\Repositories\OptionRepository;
use App\Editor\Repositories\OptionRepositoryInterface;
use App\Editor\Repositories\QuestionRepository;
use App\Editor\Repositories\QuestionRepositoryInterface;
use App\Editor\Repositories\SkillRepository;
use App\Editor\Repositories\SkillRepositoryInterface;
use App\Events\Contracts\NotificationEventInterface;
use App\Listeners\HandleNotification;
use App\Notifications\Contracts\NotificationProviderInterface;
use App\Notifications\Providers\DefaultNotificationProvider;
use App\Overview\Repositories\SeasonRepository;
use App\Overview\Repositories\SeasonRepositoryInterface;
use App\Overview\Repositories\SeasonScoreRepository;
use App\Overview\Repositories\SeasonScoreRepositoryInterface;
use App\Overview\Repositories\StudentOverviewRepository;
use App\Overview\Repositories\StudentOverviewRepositoryInterface;
use App\Profile\Repositories\BugReportRepository;
use App\Profile\Repositories\BugReportRepositoryInterface;
use App\Profile\Repositories\ProfileRepository;
use App\Profile\Repositories\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auth bindings
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        // Core Services bindings
        $this->app->bind(
            GoalRepositoryInterface::class,
            GoalRepository::class
        );
        $this->app->bind(
            HabitRepositoryInterface::class,
            HabitRepository::class
        );
        $this->app->bind(
            EnrollmentRepositoryInterface::class,
            EnrollmentRepository::class
        );
        $this->app->bind(
            \App\Core\Assets\Repositories\UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            \App\Core\Assets\Repositories\SkillRepositoryInterface::class,
            \App\Core\Assets\Repositories\SkillRepository::class
        );
        $this->app->bind(
            \App\Core\Assets\Repositories\MetricsRepositoryInterface::class,
            \App\Core\Assets\Repositories\MetricsRepository::class
        );

        // Recommendation Engine bindings
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );

        // Skill Assessment & Ranking System bindings
        $this->app->bind(
            AssessmentRepositoryInterface::class,
            AssessmentRepository::class
        );

        // Student Overview Service bindings
        $this->app->bind(
            StudentOverviewRepositoryInterface::class,
            StudentOverviewRepository::class
        );
        $this->app->bind(
            SeasonRepositoryInterface::class,
            SeasonRepository::class
        );
        $this->app->bind(
            SeasonScoreRepositoryInterface::class,
            SeasonScoreRepository::class
        );

        // Profile & Account Manager bindings
        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );
        $this->app->bind(
            BugReportRepositoryInterface::class,
            BugReportRepository::class
        );

        // Admin Console bindings
        $this->app->bind(
            MetricsRepositoryInterface::class,
            MetricsRepository::class
        );
        $this->app->bind(
            ContentRepositoryInterface::class,
            ContentRepository::class
        );
        $this->app->bind(
            SettingsRepositoryInterface::class,
            SettingsRepository::class
        );
        $this->app->bind(
            SystemSettingsServiceInterface::class,
            SystemSettingsService::class
        );

        // Editor Console bindings
        $this->app->bind(
            SkillRepositoryInterface::class,
            SkillRepository::class
        );
        $this->app->bind(
            QuestionRepositoryInterface::class,
            QuestionRepository::class
        );
        $this->app->bind(
            OptionRepositoryInterface::class,
            OptionRepository::class
        );
        $this->app->bind(
            EditorContentRepositoryInterface::class,
            EditorContentRepository::class
        );

        // Notification bindings
        $this->app->tag([DefaultNotificationProvider::class], NotificationProviderInterface::class);
        $this->app->when(HandleNotification::class)
            ->needs('$providers')
            ->giveTagged(NotificationProviderInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(NotificationEventInterface::class, HandleNotification::class);

        // Gracefully handle missing system_settings table (e.g., during tests or first deploy)
        try {
            $platformName = $this->app->make(SystemSettingsServiceInterface::class)->getPlatformName();
        } catch (\Exception $e) {
            $platformName = 'UniGrowth';
        }

        view()->share('platformName', $platformName);
    }
}
