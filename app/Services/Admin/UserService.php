<?php

namespace App\Services\Admin;

use App\Logs\HansLogging;
use App\Models\User;
use App\Repositories\User\UserRepository;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\Request;

class UserService
{
    use HansLogging;
    protected SecureEncryptionInterface $secure;
    protected UserRepository $userRepo;

    public function __construct(
        UserRepository $userRepository,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->userRepo = $userRepository;
        $this->secure = $secureEncryptionInterface;
    }

    /**
     * method change user active/inactive status
     * @param Request $request
     * @param User $user the admin performing the action
     */
    public function changeStatusUser(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $target = $id ? $this->userRepo->findById($id) : null;

            if (! $target) {
                return [
                    'success' => false,
                    'message' => 'User not found',
                    'code' => 404,
                ];
            }

            if ($target->id === $user->id) {
                return [
                    'success' => false,
                    'message' => 'You cannot change your own account status',
                    'code' => 422,
                ];
            }

            $isActive = $request->boolean('is_active');

            if ($isActive) {
                $this->userRepo->setActive($target->id);
            } else {
                $this->userRepo->setInActive($target->id);
            }

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'CHANGE_STATUS_USER',
                $user->name . ' set user id ' . $target->id . ' (' . $target->email . ') to ' . ($isActive ? 'active' : 'inactive'),
                $request
            );

            return [
                'success' => true,
                'message' => $isActive ? 'User activated' : 'User deactivated',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'CHANGE_STATUS_USER',
                $user->name . ' failed change status user, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed update status, please try again or contact support',
                'code' => 500,
            ];
        }
    }
}
