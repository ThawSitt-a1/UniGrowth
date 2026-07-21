<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\NotificationRequested;
use App\Models\User;
use App\Notifications\HubDatabaseNotification;
use App\Services\NotificationHub;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationHubTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_dispatch_creates_an_unread_database_notification(): void
    {
        $user = User::factory()->create(['preferences' => ['email' => false]]);

        app(NotificationHub::class)->dispatch(new NotificationRequested($user, [
            'message' => 'Your goal has been updated.',
            'goal_id' => 42,
        ], 'goal.updated'));

        $notification = $user->notifications()->unread()->firstOrFail();

        $this->assertSame('goal.updated', $notification->type);
        $this->assertSame('Your goal has been updated.', $notification->data['data']['message']);
        $this->assertNull($notification->read_at);
    }

    public function test_notification_can_be_marked_as_read(): void
    {
        $user = User::factory()->create();

        app(NotificationHub::class)->dispatch(new NotificationRequested($user, ['message' => 'Reminder'], 'reminder'));
        $notification = $user->notifications()->unread()->firstOrFail();
        $notification->markAsRead();

        $this->assertNotNull($notification->fresh()->read_at);
        $this->assertSame(0, $user->notifications()->unread()->count());
    }

    public function test_email_channel_is_only_used_when_enabled_in_preferences(): void
    {
        Notification::fake();
        $user = User::factory()->create(['preferences' => ['email' => true]]);

        app(NotificationHub::class)->dispatch(new NotificationRequested($user, ['message' => 'Milestone achieved'], 'milestone'));

        Notification::assertSentTo($user, function (HubDatabaseNotification $notification, array $channels): bool {
            return $channels === ['database', 'mail'];
        });
    }
}
