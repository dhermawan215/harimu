<?php

namespace App\Services\User;

use App\Contracts\User\UserInterface;
use App\Models\User;
use App\Models\UserForgot;
use App\Models\UserVerification;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use HansCrypt\Contract\SecureEncryptionInterface;

class UserService implements UserInterface
{
    protected SecureEncryptionInterface $secure;
    protected UserRepository $userRepo;

    public function __construct(
        SecureEncryptionInterface $secureEncryptionInterface,
        UserRepository $userRepository
    ) {
        $this->secure = $secureEncryptionInterface;
        $this->userRepo = $userRepository;
    }
    /**
     * method make new user verification
     * @param string $email
     * @param int $userId
     */
    public function createUserVerification(string $email, int $userId): UserVerification
    {
        $now = Carbon::now();
        try {
            $this->userRepo->deleteUserVerificationByEmail($email);

            return $this->userRepo->createUserVerification([
                'email' => $email,
                'token' => $this->secure->encode($userId),
                'token_expired' => $now->addHours(2)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * method verify user email by token
     * @param string $token
     * @return string one of VERIFY_SUCCESS, VERIFY_INVALID, VERIFY_EXPIRED
     */
    public function verifyUserEmail(string $token): string
    {
        $verification = $this->userRepo->getTokenUserVerification($token);

        if (! $verification) {
            return self::VERIFY_INVALID;
        }

        if ($verification->token_expired === null || $verification->token_expired->isPast()) {
            return self::VERIFY_EXPIRED;
        }

        $user = $this->userRepo->getUserByEmail($verification->email);

        if (! $user || (string) $this->secure->decode($token) !== (string) $user->id) {
            return self::VERIFY_INVALID;
        }

        if (! $user->email_verified_at) {
            $this->userRepo->markUserEmailVerified($user);
        }

        $this->userRepo->deleteUserVerificationByEmail($verification->email);

        return self::VERIFY_SUCCESS;
    }
    /**
     * method make new user forgot password token
     * @param string $email
     * @param int $userId
     */
    public function createUserForgotPassword(string $email, int $userId): UserForgot
    {
        $now = Carbon::now();
        try {
            $this->userRepo->deleteUserForgotByEmail($email);

            return $this->userRepo->createUserForgot([
                'email' => $email,
                'token' => $this->secure->encode($userId),
                'token_expired' => $now->addHours(2)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * method check user forgot password token without consuming it
     * @param string $token
     * @return string one of RESET_SUCCESS, RESET_INVALID, RESET_EXPIRED
     */
    public function checkUserForgotToken(string $token): string
    {
        [$status] = $this->resolveForgotToken($token);

        return $status;
    }
    /**
     * method reset user password by forgot password token
     * @param string $token
     * @param string $password
     * @return string one of RESET_SUCCESS, RESET_INVALID, RESET_EXPIRED
     */
    public function resetUserPassword(string $token, string $password): string
    {
        [$status, $user, $forgot] = $this->resolveForgotToken($token);

        if ($status !== self::RESET_SUCCESS) {
            return $status;
        }

        $this->userRepo->updateUserPassword($user, $password);
        $this->userRepo->deleteUserForgotByEmail($forgot->email);

        return self::RESET_SUCCESS;
    }
    /**
     * method resolve forgot password token into its status, user and record
     * @param string $token
     * @return array{0: string, 1: ?User, 2: ?UserForgot}
     */
    private function resolveForgotToken(string $token): array
    {
        $forgot = $this->userRepo->getTokenForgot($token);

        if (! $forgot) {
            return [self::RESET_INVALID, null, null];
        }

        if ($forgot->token_expired === null || $forgot->token_expired->isPast()) {
            return [self::RESET_EXPIRED, null, $forgot];
        }

        $user = $this->userRepo->getUserByEmail($forgot->email);

        if (! $user || (string) $this->secure->decode($token) !== (string) $user->id) {
            return [self::RESET_INVALID, null, $forgot];
        }

        return [self::RESET_SUCCESS, $user, $forgot];
    }
}
