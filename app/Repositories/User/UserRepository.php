<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserForgot;
use App\Models\UserVerification;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * method create data user verification
     * @param array $data
     */
    public function createUserVerification(array $data)
    {
        return UserVerification::create($data);
    }
    /**
     * method get token verification
     * @param string $token
     */
    public function getTokenUserVerification(string $token)
    {
        return UserVerification::where('token', $token)->first();
    }
    /**
     * method delete user verification by email
     * @param string $email
     */
    public function deleteUserVerificationByEmail(string $email): void
    {
        UserVerification::where('email', $email)->delete();
    }
    /**
     * method get user by email
     * @param string $email
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
    /**
     * method mark user email as verified
     * @param User $user
     */
    public function markUserEmailVerified(User $user): void
    {
        $user->forceFill(['email_verified_at' => now()])->save();
    }
    /**
     * method update user password, the password is hashed by the model cast
     * @param User $user
     * @param string $password
     */
    public function updateUserPassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();
    }
    /**
     * method delete user forgot by email
     * @param string $email
     */
    public function deleteUserForgotByEmail(string $email): void
    {
        UserForgot::where('email', $email)->delete();
    }
    /**
     * method create user forgot
     * @param array $data
     */
    public function createUserForgot(array $data)
    {
        return UserForgot::create($data);
    }
    /**
     * method get token user forgot
     * @param string $token
     */
    public function getTokenForgot(string $token)
    {
        return UserForgot::where('token', $token)->first();
    }
}
