<?php

namespace App\Contracts\User;

use App\Models\UserForgot;
use App\Models\UserVerification;

interface UserInterface
{
    public const VERIFY_SUCCESS = 'success';
    public const VERIFY_INVALID = 'invalid';
    public const VERIFY_EXPIRED = 'expired';

    public const RESET_SUCCESS = 'success';
    public const RESET_INVALID = 'invalid';
    public const RESET_EXPIRED = 'expired';

    /**
     * method make new user verification
     * @param string $email
     * @param int $userId
     */
    public function createUserVerification(string $email, int $userId): UserVerification;
    /**
     * method verify user email by token
     * @param string $token
     * @return string one of VERIFY_SUCCESS, VERIFY_INVALID, VERIFY_EXPIRED
     */
    public function verifyUserEmail(string $token): string;
    /**
     * method make new user forgot password token
     * @param string $email
     * @param int $userId
     */
    public function createUserForgotPassword(string $email, int $userId): UserForgot;
    /**
     * method check user forgot password token without consuming it
     * @param string $token
     * @return string one of RESET_SUCCESS, RESET_INVALID, RESET_EXPIRED
     */
    public function checkUserForgotToken(string $token): string;
    /**
     * method reset user password by forgot password token
     * @param string $token
     * @param string $password
     * @return string one of RESET_SUCCESS, RESET_INVALID, RESET_EXPIRED
     */
    public function resetUserPassword(string $token, string $password): string;
}
