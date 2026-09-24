<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\User;
use App\Services\Music\MusicService;
use App\Services\System\MusicHandlingService;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MusicController extends Controller
{
    protected User $user;
    protected SecureEncryptionInterface $secure;
    protected MusicService $music;

    public function __construct(
        SecureEncryptionInterface $secureEncryptionInterface,
        MusicService $musicService
    ) {
        $this->secure = $secureEncryptionInterface;
        $this->user = Auth::user();
        $this->music = $musicService;
    }

    public function index()
    {
        return view('admin.music.index', [
            'title' => 'Manajemen Musik'
        ]);
    }
    /**
     * method list data
     * @param Request $request
     * @return JsonResponse
     */
    public function listData(Request $request): JsonResponse
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $search = $request['search']['value'];
        $showDeleted = $request->boolean('show_deleted');
        $query = Music::select(
            'id',
            'title',
            'artist',
            'file_path',
            'duration',
            'tier',
            'is_active',
        )->where('is_delete', $showDeleted ? 1 : 0);

        if ($search) {
            $query->whereAny([
                'title',
                'artist',
            ], 'like', "%$search%");
        }

        $recordsFiltered = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)
            ->get();
        $recordsTotal = $resData->count();

        $i = $offset + 1;
        $data = [];
        $response = [];
        $arr = [];

        foreach ($resData as $key => $value) {
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $this->secure->encode($value->id) . '">';
            $data['rnum'] = $i;
            $data['title'] = $value->title ?? '';
            $data['artist'] = $value->artist ?? '';
            $data['duration'] = $value->duration ?? '';
            $data['tier'] = $value->tier ?? '';
            $data['is_active'] = '<div class="form-check form-switch mb-0">'
                . '<input type="checkbox" role="switch" class="form-check-input toggle-active" data-id="' . $this->secure->encode($value->id) . '"'
                . ($value->is_active ? ' checked' : '')
                . ($showDeleted ? ' disabled' : '')
                . '>'
                . '</div>';

            if ($showDeleted) {
                $data['action'] = '<button class="btn btn-sm btn-outline-success rounded-3 btn-restore" data-restore="' . $this->secure->encode($value->id) . '"><i class="bi bi-arrow-counterclockwise"></i></button>';
            } else {
                $data['action'] = '<a class="btn btn-sm btn-outline-secondary rounded-3" href="' . route('admin.music.stream', $this->secure->encode($value->id)) . '" target="_blank" rel="noopener"><i class="bi bi-play-fill"></i></a> '
                    . '<button data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-primary rounded-3 btn-edit" data-edit="' . $this->secure->encode($value->id) . '"><i class="bi bi-pencil"></i></button>';
            }

            $i++;
            array_push($arr, $data);
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        ]);
    }

    /**
     * method store new music
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:mp3,wav,ogg|max:7168',
            'tier' => 'required|in:free,basic,premium',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->music->saveMusic($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }

    /**
     * method get single music for edit form
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $response = $this->music->editMusic($request);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }
    /**
     * method update existing music
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:mp3,wav,ogg|max:7168',
            'tier' => 'required|in:free,basic,premium',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->music->updateMusic($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }
    /**
     * method stream music file privately (not exposed via public storage)
     * @param string $xvalue
     */
    public function stream(string $xvalue)
    {
        $id = $this->secure->decode($xvalue);
        return $this->music->getStreamMusic($id);
    }

    /**
     * method delete music (single/multiple)
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $response = $this->music->deleteMusic($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
        ], $response['code']);
    }

    /**
     * method restore soft-deleted music (single/multiple)
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(Request $request): JsonResponse
    {
        $response = $this->music->restoreMusic($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
        ], $response['code']);
    }

    /**
     * method toggle music active/inactive status
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleActive(Request $request): JsonResponse
    {
        $response = $this->music->toggleActiveMusic($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
        ], $response['code']);
    }
}
