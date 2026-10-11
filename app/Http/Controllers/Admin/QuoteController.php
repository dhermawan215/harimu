<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\User;
use App\Services\Quote\QuoteService;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class QuoteController extends Controller
{
    protected QuoteService $quote;
    protected SecureEncryptionInterface $secure;
    protected User $user;

    public function __construct(
        QuoteService $quoteService,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->quote = $quoteService;
        $this->secure = $secureEncryptionInterface;
        $this->user = Auth::user();
    }

    public function index(): View
    {
        return view('admin.quote.index', [
            'title' => 'Quote Management'
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

        $query = Quote::select(
            'id',
            'source_type',
            'reference',
            'arabic_text',
            'translation_text',
            'visibility',
            'is_active',
        );

        if ($search) {
            $query->whereAny([
                'reference',
                'arabic_text',
                'translation_text',
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
            $data['source_type'] = '<span class="badge text-bg-secondary text-uppercase">' . e($value->source_type) . '</span>';
            $data['reference'] = $value->reference ? e($value->reference) : '-';
            $data['arabic_text'] = $value->arabic_text ? '<span dir="rtl">' . e($value->arabic_text) . '</span>' : '-';
            $data['translation_text'] = $value->translation_text ? e($value->translation_text) : '-';
            $data['visibility'] = '<span class="badge text-bg-' . ($value->visibility === 'global' ? 'info' : 'warning') . ' text-uppercase">' . e($value->visibility) . '</span>';
            $data['is_active'] = '<div class="form-check form-switch mb-0">'
                . '<input type="checkbox" role="switch" class="form-check-input toggle-active" data-change-active="' . $this->secure->encode($value->id) . '"'
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
     * method store new quote
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'source_type' => 'required|in:quran,hadith,quote,custom',
            'reference' => 'nullable|string|max:255',
            'arabic_text' => 'nullable|string',
            'translation_text' => 'required|string',
            'visibility' => 'required|in:global,private',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->quote->saveQuote($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }

    /**
     * method get single quote for edit form
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $response = $this->quote->editQuote($request);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'data' => $response['data']
        ], $response['code']);
    }

    /**
     * method update existing quote
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'source_type' => 'required|in:quran,hadith,quote,custom',
            'reference' => 'nullable|string|max:255',
            'arabic_text' => 'nullable|string',
            'translation_text' => 'required|string',
            'visibility' => 'required|in:global,private',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->quote->updateQuote($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message']
        ], $response['code']);
    }

    /**
     * method change quote active/inactive status
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $response = $this->quote->changeStatusQuote($request, $this->user);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
        ], $response['code']);
    }
}
