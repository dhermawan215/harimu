<?php

namespace Tests\Feature\Auth;

use App\Mail\Auth\AccountVerificationMail;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    private function registerUser(): User
    {
        $this->post('/register', [
            'name' => 'Dicky',
            'email' => 'dicky@example.com',
            'phone' => '081234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        return User::where('email', 'dicky@example.com')->firstOrFail();
    }

    public function test_register_creates_user_token_and_sends_email(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'Dicky',
            'email' => 'dicky@example.com',
            'phone' => '081234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $response->assertSessionHas('success');

        $user = User::where('email', 'dicky@example.com')->firstOrFail();
        $this->assertNull($user->email_verified_at);

        $verification = UserVerification::where('email', 'dicky@example.com')->firstOrFail();
        $this->assertTrue($verification->token_expired->isFuture());

        Mail::assertSent(AccountVerificationMail::class, fn ($mail) => $mail->hasTo('dicky@example.com'));
    }

    public function test_valid_token_verifies_email_and_consumes_token(): void
    {
        Mail::fake();
        $user = $this->registerUser();
        $token = UserVerification::where('email', $user->email)->value('token');

        $this->get(route('verification.verify', ['token' => $token]))
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertDatabaseMissing('user_verifications', ['email' => $user->email]);
    }

    public function test_expired_token_is_rejected_and_user_stays_unverified(): void
    {
        Mail::fake();
        $user = $this->registerUser();
        $verification = UserVerification::where('email', $user->email)->firstOrFail();
        $verification->update(['token_expired' => now()->subMinute()]);

        $this->get(route('verification.verify', ['token' => $verification->token]))
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('error');

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_unknown_token_is_rejected(): void
    {
        $this->get(route('verification.verify', ['token' => 'not-a-real-token']))
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('error');
    }

    public function test_resend_replaces_old_token_and_sends_new_email(): void
    {
        Mail::fake();
        $user = $this->registerUser();
        $oldToken = UserVerification::where('email', $user->email)->value('token');
        UserVerification::where('email', $user->email)->update(['token_expired' => now()->subMinute()]);

        $this->post(route('verification.resend'), ['email' => $user->email])
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('success');

        $this->assertSame(1, UserVerification::where('email', $user->email)->count());
        $newToken = UserVerification::where('email', $user->email)->value('token');
        $this->assertNotSame($oldToken, $newToken);
        Mail::assertSent(AccountVerificationMail::class, 2);

        $this->get(route('verification.verify', ['token' => $newToken]))->assertRedirect(route('login'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_notice_page_renders_resend_form_and_flash_messages(): void
    {
        $this->get(route('verification.notice'))
            ->assertOk()
            ->assertSee('Kirim Ulang Email Verifikasi');

        $this->get(route('verification.verify', ['token' => 'not-a-real-token']), )
            ->assertRedirect(route('verification.notice'));

        $this->followingRedirects()
            ->get(route('verification.verify', ['token' => 'not-a-real-token']))
            ->assertSee('Tautan verifikasi tidak valid');
    }

    public function test_login_page_shows_success_message_after_verification(): void
    {
        Mail::fake();
        $user = $this->registerUser();
        $token = UserVerification::where('email', $user->email)->value('token');

        $this->followingRedirects()
            ->get(route('verification.verify', ['token' => $token]))
            ->assertSee('Email berhasil diverifikasi.');
    }

    public function test_resend_sends_nothing_for_unknown_or_already_verified_email(): void
    {
        Mail::fake();
        $verified = User::factory()->create(['email_verified_at' => now()]);

        foreach (['nobody@example.com', $verified->email] as $email) {
            $this->post(route('verification.resend'), ['email' => $email])
                ->assertRedirect(route('verification.notice'))
                ->assertSessionHas('success');
        }

        Mail::assertNothingSent();
    }
}
