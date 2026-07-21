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
        $this->app->bind(
            \App\Auth\Repositories\UserRepositoryInterface::class,
            \App\Auth\Repositories\EloquentUserRepository::class // Ensure this path is correct!
        );

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
