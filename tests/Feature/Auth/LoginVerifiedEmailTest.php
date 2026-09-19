<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginVerifiedEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_user_can_login(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_unverified_user_with_correct_password_is_blocked_and_sent_to_notice_page(): void
    {
        $user = User::factory()->unverified()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('email', $user->email)
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_unverified_user_sees_resend_form_prefilled_after_being_blocked(): void
    {
        $user = User::factory()->unverified()->create();

        $this->followingRedirects()
            ->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSee('Email Anda belum diverifikasi')
            ->assertSee($user->email);
    }

    public function test_wrong_password_for_unverified_user_does_not_reveal_verification_state(): void
    {
        $user = User::factory()->unverified()->create();

        $this->from('/login')
            ->post('/login', ['email' => $user->email, 'password' => 'wrong-password'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
