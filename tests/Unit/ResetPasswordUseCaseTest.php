<?php

namespace Tests\Unit;

use App\Auth\DTOs\ResetPasswordDTO;
use App\Auth\UseCases\ResetPasswordUseCase;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\AuthSessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class ResetPasswordUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function createMockAuthSession(bool $expectInvalidate = false, int $userId = 0): AuthSessionService
    {
        $mock = Mockery::mock(AuthSessionService::class);

        if ($expectInvalidate) {
            $mock->shouldReceive('invalidateAllSessionsForUser')
                ->once()
                ->with($userId);

            $mock->shouldReceive('login')
                ->once()
                ->with(Mockery::type(\Illuminate\Contracts\Auth\Authenticatable::class), false);
        }

        return $mock;
    }

    public function test_it_generates_and_stores_reset_token(): void
    {
        $email = 'john@example.com';

        // Create a user first (required for the new model)
        $user = User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());

        $token = $useCase->requestReset($email);

        $this->assertIsString($token);
        $this->assertDatabaseHas('password_resets', [
            'user_id' => $user->id,
        ]);
    }

    public function test_request_reset_throws_exception_for_nonexistent_user(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('User not found.');

        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());
        $useCase->requestReset('does-not-exist@example.com');
    }

    public function test_it_resets_password_successfully(): void
    {
        $email = 'john@example.com';
        $password = 'NewPassword123!';

        // Create a real user in the test db
        $user = User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        // Generate a reset token
        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());
        $token = $useCase->requestReset($email);

        $useCase2 = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession(
            expectInvalidate: true,
            userId: $user->id,
        ));

        $result = $useCase2->execute(new ResetPasswordDTO(
            token: $token,
            email: $email,
            password: $password,
        ));

        $this->assertTrue($result['success']);
        $this->assertEquals('Password has been reset successfully. You are now logged in.', $result['message']);

        // Verify the password was actually changed using Eloquent
        $user->refresh();
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertFalse(Hash::check('OldPassword123!', $user->password));

        // Verify the token was deleted
        $this->assertDatabaseMissing('password_resets', [
            'user_id' => $user->id,
        ]);
    }

    public function test_it_returns_error_when_user_not_found(): void
    {
        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());

        $result = $useCase->execute(new ResetPasswordDTO(
            token: 'some-token',
            email: 'unknown@example.com',
            password: 'NewPassword123!',
        ));

        $this->assertFalse($result['success']);
        $this->assertEquals('User not found.', $result['message']);
    }

    public function test_it_returns_error_when_token_is_invalid(): void
    {
        $email = 'john@example.com';

        // Create a user but don't generate a token
        User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());

        $result = $useCase->execute(new ResetPasswordDTO(
            token: 'invalid-token',
            email: $email,
            password: 'NewPassword123!',
        ));

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid or expired reset token.', $result['message']);
    }

    public function test_it_returns_error_when_token_does_not_match(): void
    {
        $email = 'john@example.com';

        // Create a user
        $user = User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        // Generate a token via use case
        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());
        $useCase->requestReset($email); // This creates a real token

        // Now try with a different token
        $result = $useCase->execute(new ResetPasswordDTO(
            token: 'wrong-token',
            email: $email,
            password: 'NewPassword123!',
        ));

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid or expired reset token.', $result['message']);
    }

    public function test_it_rejects_expired_token(): void
    {
        $email = 'john@example.com';

        // Create a user
        $user = User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        // Generate a reset token
        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());
        $token = $useCase->requestReset($email);

        // Manually expire the token by setting expires_at to 1 minute ago
        PasswordReset::query()
            ->where('user_id', $user->id)
            ->update(['expires_at' => now()->subMinute()]);

        // Try to use the expired token
        $result = $useCase->execute(new ResetPasswordDTO(
            token: $token,
            email: $email,
            password: 'NewPassword123!',
        ));

        // The notExpired() scope filters it at query level → "Invalid or expired reset token."
        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid or expired reset token.', $result['message']);

        // Verify the password was NOT changed
        $user->refresh();
        $this->assertFalse(Hash::check('NewPassword123!', $user->password));
        $this->assertTrue(Hash::check('OldPassword123!', $user->password));
    }

    public function test_expired_token_record_stays_in_db_for_traceability(): void
    {
        $email = 'john@example.com';

        // Create a user
        $user = User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        // Generate a reset token
        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());
        $token = $useCase->requestReset($email);

        // Manually expire the token
        PasswordReset::query()
            ->where('user_id', $user->id)
            ->update(['expires_at' => now()->subMinute()]);

        // Attempt reset with expired token
        $result = $useCase->execute(new ResetPasswordDTO(
            token: $token,
            email: $email,
            password: 'NewPassword123!',
        ));

        // notExpired() scope excludes expired records at query level,
        // so the isExpired() cleanup branch is never reached.
        // The record remains in DB for audit traceability.
        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid or expired reset token.', $result['message']);
        $this->assertDatabaseHas('password_resets', [
            'user_id' => $user->id,
        ]);
    }

    public function test_renewed_token_overwrites_expired_one(): void
    {
        $email = 'john@example.com';

        // Create a user
        $user = User::query()->create([
            'username' => 'john',
            'email' => $email,
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        // Generate a token and expire it
        $useCase = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession());
        $firstToken = $useCase->requestReset($email);

        PasswordReset::query()
            ->where('user_id', $user->id)
            ->update(['expires_at' => now()->subMinute()]);

        // User clicks "Resend" — requestReset() overwrites via updateOrCreate
        $renewedToken = $useCase->requestReset($email);

        // Verify old record was replaced with fresh token + expiry
        $record = PasswordReset::query()->where('user_id', $user->id)->first();

        $this->assertNotNull($record);
        $this->assertEquals($renewedToken, $record->token);
        $this->assertNotEquals($firstToken, $record->token);
        $this->assertTrue($record->expires_at->greaterThan(now())); // fresh 20-min expiry

        // Use renewed token — should succeed
        $useCase2 = new ResetPasswordUseCase(new User(), new PasswordReset(), $this->createMockAuthSession(
            expectInvalidate: true,
            userId: $user->id,
        ));

        $result = $useCase2->execute(new ResetPasswordDTO(
            token: $renewedToken,
            email: $email,
            password: 'NewPassword123!',
        ));

        $this->assertTrue($result['success']);
    }
}
