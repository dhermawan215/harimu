<?php

namespace App\Services\Auth;

use App\Contracts\User\UserInterface;
use App\Logs\HansLogging;
use App\Mail\Auth\AccountVerificationMail;
use App\Mail\Auth\ResetPasswordMail;
use App\Models\User;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    use HansLogging;
    protected UserInterface $userInterface;
    protected SecureEncryptionInterface $secure;

    public function __construct(
        UserInterface $userInterface,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->userInterface = $userInterface;
        $this->secure = $secureEncryptionInterface;
    }
    /**
     * method create user verification and send the verification email
     * @param User $user
     * @return bool false if the token could not be created or the email could not be sent
     */
    public function createVerification(User $user): bool
    {
        try {
            $verification = $this->userInterface->createUserVerification($user->email, $user->id);

            Mail::to($user->email)->send(new AccountVerificationMail(
                $user->name,
                route('verification.verify', ['token' => $verification->token]),
                (int) round(now()->diffInMinutes($verification->token_expired))
            ));
            return true;
        } catch (\Throwable $th) {
            report($th);

            return false;
        }
    }
    /**
     * method verify user email by token
     * @param string $token
     * @return string one of UserInterface::VERIFY_SUCCESS, VERIFY_INVALID, VERIFY_EXPIRED
     */
    public function verifyEmail(string $token): string
    {
        return $this->userInterface->verifyUserEmail($token);
    }
    /**
     * method request password reset, silently ignored for unknown emails
     * @param string $email
     * @param string $ip
     */
    public function requestPasswordReset(string $email, string $ip): void
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return;
        }

        try {
            $forgot = $this->userInterface->createUserForgotPassword($user->email, $user->id);

            Mail::to($user->email)->send(new ResetPasswordMail(
                $user->name,
                route('password.reset', ['token' => $forgot->token]),
                (int) round(now()->diffInMinutes($forgot->token_expired)),
                $ip,
                now()->format('d M Y, H:i T')
            ));
        } catch (\Throwable $th) {
            report($th);
        }
    }
    /**
     * method check password reset token without consuming it
     * @param string $token
     * @return string one of UserInterface::RESET_SUCCESS, RESET_INVALID, RESET_EXPIRED
     */
    public function checkResetToken(string $token): string
    {
        return $this->userInterface->checkUserForgotToken($token);
    }
    /**
     * method reset password by token
     * @param string $token
     * @param string $password
     * @return string one of UserInterface::RESET_SUCCESS, RESET_INVALID, RESET_EXPIRED
     */
    public function resetPassword(string $token, string $password): string
    {
        return $this->userInterface->resetUserPassword($token, $password);
    }
    /**
     * method resend verification email, silently ignored for unknown or already verified emails
     * @param string $email
     */
    public function resendVerification(string $email): void
    {
        $user = User::where('email', $email)->whereNull('email_verified_at')->first();

        if ($user) {
            $this->createVerification($user);
        }
    }
}
