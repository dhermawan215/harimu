<?php

namespace App\Services\Music;

use App\Logs\HansLogging;
use App\Models\User;
use App\Repositories\Music\MusicRepository;
use App\Services\System\MusicHandlingService;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\Request;

class MusicService
{
    use HansLogging;
    protected SecureEncryptionInterface $secure;
    protected MusicRepository $musicRepo;
    protected MusicHandlingService $musicStorageService;

    public function __construct(
        MusicRepository $musicRepository,
        SecureEncryptionInterface $secureEncryptionInterface,
        MusicHandlingService $musicHandlingService
    ) {
        $this->musicRepo = $musicRepository;
        $this->secure = $secureEncryptionInterface;
        $this->musicStorageService = $musicHandlingService;
    }
    /**
     * method save mucis
     * @param Request $request
     * @param User user
     */
    public function saveMusic(Request $request, User $user)
    {
        try {
            $upload = $this->musicStorageService->uploadMusic($request->file('file'));

            if (! $upload['success']) {
                return [
                    'success' => false,
                    'message' => $upload['message'],
                    'code' => 422
                ];
            }

            $duration = $this->musicStorageService->getDuration($upload['path']);

            $this->musicRepo->createData([
                'title' => $request->title,
                'artist' => $request->artist ?? null,
                'file_path' => $upload['path'],
                'duration' => $duration,
                'tier' => $request->tier,
                'is_active' => $request->is_active,
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'SAVE_MUSIC',
                $user->name . ' success save music',
                $request
            );

            return [
                'success' => true,
                'message' => 'Data saved',
                'code' => 200
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'SAVE_MUSIC',
                $user->name . ' failed save music, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed save music, please try again or contact support',
                'code' => 500
            ];
        }
    }
    /**
     * method get stream music
     * @param int $id
     */
    public function getStreamMusic(int $id)
    {
        $music = $id ? $this->musicRepo->findActiveMusic($id) : null;

        if (! $music || ! $music->file_path) {
            abort(404, 'File not found');
        }

        $extension = pathinfo($music->file_path, PATHINFO_EXTENSION);

        return $this->musicStorageService->streamMusic(
            $music->title . ($extension ? '.' . $extension : ''),
            $music->file_path
        );
    }
    /**
     * method delete music
     * @param Request $request
     * @param User $user
     */
    public function deleteMusic(Request $request, User $user)
    {
        try {
            $encryptedIds = (array) $request->dValue;
            $ids = collect($encryptedIds)
                ->map(fn($value) => $this->secure->decode((string) $value))
                ->filter()
                ->values()->all();

            $this->musicRepo->deleteDatas($ids);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'DELETE_MUSIC',
                $user->name . ' success delete music, id: ' . json_encode($ids),
                $request
            );

            return [
                'success' => true,
                'message' => 'Success delete music',
                'code' => 200
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'DELETE_MUSIC',
                $user->name . ' failed delete music, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed delete music, please try again or contact support',
                'code' => 500
            ];
        }
    }

    /**
     * method restore deleted music
     * @param Request $request
     * @param User $user
     */
    public function restoreMusic(Request $request, User $user)
    {
        try {
            $encryptedIds = (array) $request->dValue;
            $ids = collect($encryptedIds)
                ->map(fn($value) => $this->secure->decode((string) $value))
                ->filter()
                ->values()->all();

            $this->musicRepo->restoreDatas($ids);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'RESTORE_MUSIC',
                $user->name . ' success restore music, id: ' . json_encode($ids),
                $request
            );

            return [
                'success' => true,
                'message' => 'Success restore music',
                'code' => 200
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'RESTORE_MUSIC',
                $user->name . ' failed restore music, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed restore music, please try again or contact support',
                'code' => 500
            ];
        }
    }
    /**
     * method edit music
     * @param Request $request
     */
    public function editMusic(Request $request)
    {
        $id = $this->secure->decode((string) $request->xvalue);
        $music = $id ? $this->musicRepo->findActiveMusic($id) : null;

        if (! $music) {
            return [
                'code'  => 404,
                'message' => 'music not found',
                'success' => false,
                'data' => null,
            ];
        }

        $data = [
            'xvalue' => $request->xvalue,
            'title' => $music->title,
            'artist' => $music->artist,
            'duration' => $music->duration,
            'tier' => $music->tier,
            'is_active' => (bool) $music->is_active,
            'file_name' => $music->file_path ? basename($music->file_path) : null,
        ];

        return [
            'code' => 200,
            'message' => 'data retrieved',
            'success' => true,
            'data' => $data
        ];
    }
    /**
     * method update music
     * @param Request $request
     * @param User $user
     */
    public function updateMusic(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $music = $id ? $this->musicRepo->findActiveMusic($id) : null;

            if (! $music) {
                return [
                    'success' => false,
                    'message' => 'Music not found',
                    'code' => 404,
                ];
            }

            $filePath = $music->file_path;
            $duration = $music->duration;

            if ($request->hasFile('file')) {
                $upload = $this->musicStorageService->uploadMusic($request->file('file'));

                if (! $upload['success']) {
                    return [
                        'success' => false,
                        'message' => $upload['message'],
                        'code' => 422,
                    ];
                }

                if ($music->file_path) {
                    $this->musicStorageService->deleteMusic($music->file_path);
                }

                $filePath = $upload['path'];
                $duration = $this->musicStorageService->getDuration($upload['path']);
            }

            $music->update([
                'title' => $request->title,
                'artist' => $request->artist ?? null,
                'file_path' => $filePath,
                'duration' => $duration,
                'tier' => $request->tier,
                'is_active' => $request->boolean('is_active'),
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'UPDATE_MUSIC',
                $user->name . ' success update music, id: ' . $id,
                $request
            );

            return [
                'success' => true,
                'message' => 'Music updated successfully',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'UPDATE_MUSIC',
                $user->name . ' failed update music, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed update music, please try again or contact support',
                'code' => 500,
            ];
        }
    }

    /**
     * method toggle music active/inactive status
     * @param Request $request
     * @param User $user
     */
    public function toggleActiveMusic(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $music = $id ? $this->musicRepo->findActiveMusic($id) : null;

            if (! $music) {
                return [
                    'success' => false,
                    'message' => 'Music not found',
                    'code' => 404,
                ];
            }

            $isActive = $request->boolean('is_active');

            if ($isActive) {
                $this->musicRepo->setMusicActive($music->id);
            } else {
                $this->musicRepo->setMusicInActive($music->id);
            }

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'TOGGLE_ACTIVE_MUSIC',
                $user->name . ' set music id ' . $music->id . ' to ' . ($isActive ? 'active' : 'inactive'),
                $request
            );

            return [
                'success' => true,
                'message' => $isActive ? 'Music activated' : 'Music deactivated',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'TOGGLE_ACTIVE_MUSIC',
                $user->name . ' failed toggle active music, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
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
