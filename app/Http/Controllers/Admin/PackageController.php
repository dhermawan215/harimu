<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use App\Services\Package\PackageService;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PackageController extends Controller
{
    protected PackageService $package;
    protected SecureEncryptionInterface $secure;
    protected User $user;

    public function __construct(
        PackageService $packageService,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->package = $packageService;
        $this->secure = $secureEncryptionInterface;
        $this->user = Auth::user();
    }

    public function index(): View
    {
        return view('admin.package.index', [
            'title' => 'Package Management'
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
        $showInActive = $request->boolean('show_inactive');

        $query = Package::select(
            'id',
            'name',
            'description',
            'price',
            'duration_days',
            'max_invitations',
            'max_guests',
            'max_wa_blast',
            'template_tier',
            'is_active',
        )->where('is_active', $showInActive ? 0 : 1);

        if ($search) {
            $query->whereAny([
                'name',
                'price',
                'description'
            ], 'like', "%$search%");
        }

        $recordsFiltered = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)
            ->get();
        $recordsTotal = $resData->count();

        $i = $offset + 1;
        $arr = [];

        foreach ($resData as $value) {
            $data = [];
            $data['rnum'] = $i;
            $data['name'] = '<div>'
                . '<strong>' . e($value->name) . '</strong>'
                . ($value->description ? '<p class="mb-0 text-muted small">' . e($value->description) . '</p>' : '')
                . '</div>';
            $data['price'] = $value->price !== null ? 'Rp' . number_format($value->price, 0, ',', '.') : '-';
            $data['duration'] = $value->duration_days ? $value->duration_days . ' Days' : '-';
            $data['invitation'] = $value->max_invitations ?? '-';
            $data['guest'] = $value->max_guests ?? '-';
            $data['max_wa_blast'] = $value->max_wa_blast ?? '-';
            $data['tier'] = '<span class="badge text-bg-secondary text-uppercase">' . e($value->template_tier) . '</span>';
            $data['is_active'] = '<div class="form-check form-switch mb-0">'
                . '<input type="checkbox" role="switch" class="form-check-input toggle-active" data-id="' . $this->secure->encode($value->id) . '"'
                . ($value->is_active ? ' checked' : '')
                . '>'
                . '</div>';
            $data['action'] = '<button type="button" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-primary rounded-3 btn-edit" data-edit="' . $this->secure->encode($value->id) . '"><i class="bi bi-pencil"></i></button>';
            $i++;
            array_push($arr, $data);
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        ]);
    }
    /**
     * method store new package
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'max_invitations' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'max_wa_blast' => 'required|integer|min:0',
            'template_tier' => 'required|in:free,basic,premium',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->package->savePackage($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }
    /**
     * method get single package for edit form
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $response = $this->package->editPackage($request);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * method update existing package
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'max_invitations' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'max_wa_blast' => 'required|integer|min:0',
            'template_tier' => 'required|in:free,basic,premium',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->package->updatePackage($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }
    /**
     * method change package active/inactive status
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $response = $this->package->changeStatusPackage($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
        ], $response['code']);
    }
}
