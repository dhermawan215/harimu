<?php

namespace App\Services\Package;

use App\Contracts\Package\PackageInterface;
use App\Logs\HansLogging;
use App\Models\User;
use App\Repositories\package\PackageRepository;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageService implements PackageInterface
{
    use HansLogging;
    protected SecureEncryptionInterface $secure;
    protected PackageRepository $packageRepo;

    public function __construct(
        PackageRepository $packageRepository,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->packageRepo = $packageRepository;
        $this->secure = $secureEncryptionInterface;
    }
    /**
     * method generate a slug from the package name, guaranteed unique
     * @param string $name
     * @param int|null $exceptId package id to ignore during the uniqueness check (used on update)
     */
    protected function generateSlug(string $name, ?int $exceptId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 1;

        while ($this->packageRepo->isSlugTaken($slug, $exceptId)) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        return $slug;
    }
    /**
     * method save package
     * @param Request $request
     * @param User $user
     */
    public function savePackage(Request $request, User $user)
    {
        try {
            $this->packageRepo->createNewPackage([
                'name' => $request->name,
                'slug' => $this->generateSlug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'duration_days' => $request->duration_days ?: null,
                'max_invitations' => $request->max_invitations,
                'max_guests' => $request->max_guests,
                'max_wa_blast' => $request->max_wa_blast,
                'template_tier' => $request->template_tier,
                'is_active' => $request->boolean('is_active'),
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'SAVE_PACKAGE',
                $user->name . ' success save package',
                $request
            );

            return [
                'success' => true,
                'message' => 'Package saved successfully',
                'code' => 200
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'SAVE_PACKAGE',
                $user->name . ' failed save package, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed save package, please try again or contact support',
                'code' => 500
            ];
        }
    }
    /**
     * method edit package
     * @param Request $request
     */
    public function editPackage(Request $request)
    {
        $id = $this->secure->decode((string) $request->xvalue);
        $package = $id ? $this->packageRepo->findById($id) : null;

        if (! $package) {
            return [
                'success' => false,
                'message' => 'Package not found',
                'code' => 404,
                'data' => null,
            ];
        }

        $data = [
            'xvalue' => $request->xvalue,
            'name' => $package->name,
            'description' => $package->description,
            'price' => $package->price,
            'duration_days' => $package->duration_days,
            'max_invitations' => $package->max_invitations,
            'max_guests' => $package->max_guests,
            'max_wa_blast' => $package->max_wa_blast,
            'template_tier' => $package->template_tier,
            'is_active' => (bool) $package->is_active,
        ];

        return [
            'success' => true,
            'message' => 'data retrieved',
            'code' => 200,
            'data' => $data
        ];
    }
    /**
     * method update package
     * @param Request $request
     * @param User $user
     */
    public function updatePackage(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $package = $id ? $this->packageRepo->findById($id) : null;

            if (! $package) {
                return [
                    'success' => false,
                    'message' => 'Package not found',
                    'code' => 404,
                ];
            }

            $slug = $package->name === $request->name
                ? $package->slug
                : $this->generateSlug($request->name, $package->id);

            $package->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'duration_days' => $request->duration_days ?: null,
                'max_invitations' => $request->max_invitations,
                'max_guests' => $request->max_guests,
                'max_wa_blast' => $request->max_wa_blast,
                'template_tier' => $request->template_tier,
                'is_active' => $request->boolean('is_active'),
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'UPDATE_PACKAGE',
                $user->name . ' success update package, id: ' . $id,
                $request
            );

            return [
                'success' => true,
                'message' => 'Package updated successfully',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'UPDATE_PACKAGE',
                $user->name . ' failed update package, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed update package, please try again or contact support',
                'code' => 500
            ];
        }
    }
    /**
     * method change package active/inactive status
     * @param Request $request
     * @param User $user
     */
    public function changeStatusPackage(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $package = $id ? $this->packageRepo->findById($id) : null;

            if (! $package) {
                return [
                    'success' => false,
                    'message' => 'Package not found',
                    'code' => 404,
                ];
            }

            $isActive = $request->boolean('is_active');

            if ($isActive) {
                $this->packageRepo->makePackageActive($package->id);
            } else {
                $this->packageRepo->makePackageInActive($package->id);
            }

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'CHANGE_STATUS_PACKAGE',
                $user->name . ' set package id ' . $package->id . ' to ' . ($isActive ? 'active' : 'inactive'),
                $request
            );

            return [
                'success' => true,
                'message' => $isActive ? 'Package activated' : 'Package deactivated',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'CHANGE_STATUS_PACKAGE',
                $user->name . ' failed change status package, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
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
