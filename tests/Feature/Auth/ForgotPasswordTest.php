<?php

namespace Tests\Feature\Auth;

use App\Mail\Auth\ResetPasswordMail;
use App\Models\User;
use App\Models\UserForgot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    private function requestReset(User $user): string
    {
        $this->post(route('password.email'), ['email' => $user->email]);

        return UserForgot::where('email', $user->email)->value('token');
    }

    public function test_forgot_password_page_renders(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Kirim Tautan Atur Ulang');

        $this->get(route('login'))->assertSee('Lupa kata sandi?');
    }

    public function test_request_creates_token_and_sends_renderable_email(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('success');

        $forgot = UserForgot::where('email', $user->email)->firstOrFail();
        $this->assertTrue($forgot->token_expired->isFuture());

        Mail::assertSent(ResetPasswordMail::class, function (ResetPasswordMail $mail) use ($user, $forgot) {
            $mail->assertSeeInHtml('Atur ulang kata sandi');
            $mail->assertSeeInHtml(route('password.reset', ['token' => $forgot->token]));

            return $mail->hasTo($user->email);
        });
    }

    public function test_request_for_unknown_email_sends_nothing_but_responds_the_same(): void
    {
        Mail::fake();

        $this->post(route('password.email'), ['email' => 'nobody@example.com'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('success');

        Mail::assertNothingSent();
        $this->assertDatabaseCount('user_forgots', 0);
    }

    public function test_repeated_request_replaces_the_previous_token(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $first = $this->requestReset($user);
        $second = $this->requestReset($user);

        $this->assertNotSame($first, $second);
        $this->assertSame(1, UserForgot::where('email', $user->email)->count());
    }

    public function test_reset_form_renders_for_valid_token(): void
    {
        Mail::fake();
        $token = $this->requestReset(User::factory()->create());

        $this->get(route('password.reset', ['token' => $token]))
            ->assertOk()
            ->assertSee('Simpan Kata Sandi');
    }

    public function test_valid_token_resets_password_and_is_single_use(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $token = $this->requestReset($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertRedirect(route('login'))->assertSessionHas('success');

        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
        $this->assertDatabaseMissing('user_forgots', ['email' => $user->email]);

        $this->post(route('password.update'), [
            'token' => $token,
            'password' => 'AnotherPassword123!',
            'password_confirmation' => 'AnotherPassword123!',
        ])->assertRedirect(route('password.request'))->assertSessionHas('error');

        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_expired_token_is_rejected_on_form_and_on_submit(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $token = $this->requestReset($user);
        UserForgot::where('email', $user->email)->update(['token_expired' => now()->subMinute()]);

        $this->get(route('password.reset', ['token' => $token]))
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('error');

        $this->post(route('password.update'), [
            'token' => $token,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertRedirect(route('password.request'))->assertSessionHas('error');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_unknown_token_is_rejected(): void
    {
        $this->get(route('password.reset', ['token' => 'not-a-real-token']))
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('error');

        $this->post(route('password.update'), [
            'token' => 'not-a-real-token',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertRedirect(route('password.request'));
    }

    public function test_mismatched_confirmation_is_rejected_and_password_unchanged(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $token = $this->requestReset($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        $this->assertDatabaseHas('user_forgots', ['email' => $user->email]);
    }
}
