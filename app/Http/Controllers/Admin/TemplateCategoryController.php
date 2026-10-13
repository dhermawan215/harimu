<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateCategory;
use App\Models\User;
use App\Services\Template\TemplateCategoryService;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TemplateCategoryController extends Controller
{
    protected TemplateCategoryService $templateCategory;
    protected SecureEncryptionInterface $secure;
    protected ?User $user;

    public function __construct(
        TemplateCategoryService $templateCategoryService,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->templateCategory = $templateCategoryService;
        $this->secure = $secureEncryptionInterface;
        $this->user = Auth::user();
    }

    public function index(): View
    {
        return view('admin.template.category', [
            'title' => 'Template Category Management'
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

        $query = TemplateCategory::select(
            'id',
            'name',
            'slug',
        );

        if ($search) {
            $query->whereAny([
                'name',
                'slug',
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
            $data['name'] = e($value->name);
            $data['slug'] = '<code>' . e($value->slug) . '</code>';
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
     * method store new template category
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->templateCategory->saveCategory($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }
    /**
     * method get single template category for edit form
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $response = $this->templateCategory->editCategory($request);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }
    /**
     * method update existing template category
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->templateCategory->updateCategory($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }
}
