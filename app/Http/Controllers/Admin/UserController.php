<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\UserService;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    protected UserService $user;
    protected SecureEncryptionInterface $secure;
    protected User $authUser;

    public function __construct(
        UserService $userService,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->user = $userService;
        $this->secure = $secureEncryptionInterface;
        $this->authUser = Auth::user();
    }

    public function index(): View
    {
        return view('admin.user.index', [
            'title' => 'User Management'
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

        $query = User::select(
            'id',
            'name',
            'email',
            'phone',
            'role',
            'email_verified_at',
            'is_active',
            'is_login',
            'last_login_at',
            'last_login_ip',
            'created_at',
        )->where('is_active', $showInActive ? 0 : 1);

        if ($search) {
            $query->whereAny([
                'name',
                'email',
                'phone',
            ], 'like', "%$search%");
        }

        $recordsFiltered = $query->count();
        $resData = $query->orderByDesc('created_at')
            ->skip($offset)
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
                . '<p class="mb-0 text-muted small">' . e($value->email) . '</p>'
                . '</div>';
            $data['phone'] = $value->phone ? e($value->phone) : '-';
            $data['role'] = '<span class="badge text-bg-' . ($value->role === 'admin' ? 'dark' : 'secondary') . ' text-uppercase">' . e($value->role) . '</span>';
            $data['verified'] = $value->email_verified_at
                ? '<span class="badge text-bg-success">Verified</span>'
                : '<span class="badge text-bg-warning">Unverified</span>';
            $data['online'] = $value->is_login
                ? '<span class="badge text-bg-success">Online</span>'
                : '<span class="badge text-bg-secondary">Offline</span>';
            $data['last_login'] = $value->last_login_at
                ? $value->last_login_at->format('d M Y H:i') . ($value->last_login_ip ? '<br><span class="text-muted small">' . e($value->last_login_ip) . '</span>' : '')
                : '-';
            $data['is_active'] = '<div class="form-check form-switch mb-0">'
                . '<input type="checkbox" role="switch" class="form-check-input toggle-active" data-change-active="' . $this->secure->encode($value->id) . '"'
                . ($value->is_active ? ' checked' : '')
                . ($value->id === $this->authUser->id ? ' disabled' : '')
                . '>'
                . '</div>';
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
     * method change user active/inactive status
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $response = $this->user->changeStatusUser($request, $this->authUser);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
        ], $response['code']);
    }
}
