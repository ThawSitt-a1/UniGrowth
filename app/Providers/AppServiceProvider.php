<?php

namespace App\Providers;

use App\Events\Contracts\NotificationEventInterface;
use App\Listeners\HandleNotification;
use App\Notifications\Contracts\NotificationProviderInterface;
use App\Notifications\Providers\DefaultNotificationProvider;
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
            \App\Auth\Repositories\UserRepositoryInterface::class,
            \App\Auth\Repositories\EloquentUserRepository::class
        );

        // Core Services bindings
        $this->app->bind(
            \App\Core\Assets\Repositories\GoalRepositoryInterface::class,
            \App\Core\Assets\Repositories\GoalRepository::class
        );
        $this->app->bind(
            \App\Core\Assets\Repositories\EnrollmentRepositoryInterface::class,
            \App\Core\Assets\Repositories\EnrollmentRepository::class
        );
        $this->app->bind(
            \App\Core\Assets\Repositories\UserRepositoryInterface::class,
            \App\Core\Assets\Repositories\UserRepository::class
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
            \App\Core\Recommendation\Repositories\TagRepositoryInterface::class,
            \App\Core\Recommendation\Repositories\TagRepository::class
        );

        // Skill Assessment & Ranking System bindings
        $this->app->bind(
            \App\Assessment\Repositories\AssessmentRepositoryInterface::class,
            \App\Assessment\Repositories\AssessmentRepository::class
        );

        // Student Overview Service bindings
        $this->app->bind(
            \App\Overview\Repositories\StudentOverviewRepositoryInterface::class,
            \App\Overview\Repositories\StudentOverviewRepository::class
        );
        $this->app->bind(
            \App\Overview\Repositories\SeasonRepositoryInterface::class,
            \App\Overview\Repositories\SeasonRepository::class
        );
        $this->app->bind(
            \App\Overview\Repositories\SeasonScoreRepositoryInterface::class,
            \App\Overview\Repositories\SeasonScoreRepository::class
        );

        // Profile & Account Manager bindings
        $this->app->bind(
            \App\Profile\Repositories\ProfileRepositoryInterface::class,
            \App\Profile\Repositories\ProfileRepository::class
        );
        $this->app->bind(
            \App\Profile\Repositories\BugReportRepositoryInterface::class,
            \App\Profile\Repositories\BugReportRepository::class
        );

        // Admin Console bindings
        $this->app->bind(
            \App\Admin\Repositories\MetricsRepositoryInterface::class,
            \App\Admin\Repositories\MetricsRepository::class
        );
        $this->app->bind(
            \App\Admin\Repositories\ContentRepositoryInterface::class,
            \App\Admin\Repositories\ContentRepository::class
        );
        $this->app->bind(
            \App\Admin\Repositories\SettingsRepositoryInterface::class,
            \App\Admin\Repositories\SettingsRepository::class
        );

        // Editor Console bindings
        $this->app->bind(
            \App\Editor\Repositories\SkillRepositoryInterface::class,
            \App\Editor\Repositories\SkillRepository::class
        );
        $this->app->bind(
            \App\Editor\Repositories\QuestionRepositoryInterface::class,
            \App\Editor\Repositories\QuestionRepository::class
        );
        $this->app->bind(
            \App\Editor\Repositories\OptionRepositoryInterface::class,
            \App\Editor\Repositories\OptionRepository::class
        );
        $this->app->bind(
            \App\Editor\Repositories\EditorContentRepositoryInterface::class,
            \App\Editor\Repositories\EditorContentRepository::class
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
    }
}
