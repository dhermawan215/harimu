<?php

namespace App\Services\Quote;

use App\Logs\HansLogging;
use App\Models\User;
use App\Repositories\Quote\QuoteRepository;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\Request;

class QuoteService
{
    use HansLogging;
    protected SecureEncryptionInterface $secure;
    protected QuoteRepository $quoteRepo;

    public function __construct(SecureEncryptionInterface $secureEncryptionInterface, QuoteRepository $quoteRepository)
    {
        $this->secure = $secureEncryptionInterface;
        $this->quoteRepo = $quoteRepository;
    }
    /**
     * method save quote
     * @param Request $request
     * @param User $user
     */
    public function saveQuote(Request $request, User $user)
    {
        try {
            $this->quoteRepo->createData([
                'source_type' => $request->source_type,
                'reference' => $request->reference,
                'arabic_text' => $request->arabic_text,
                'translation_text' => $request->translation_text,
                'created_by' => $user->id,
                'visibility' => $request->visibility,
                'is_active' => $request->boolean('is_active'),
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'CREATE_QUOTE',
                $user->name . ' is successfully create new quote data',
                $request
            );

            return [
                'code' => 200,
                'success' => true,
                'message' => 'Data saved!'
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'CREATE_QUOTE',
                $user->name . ' failed create new quote, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed create new data, please try again or contact support',
                'code' => 500,
            ];
        }
    }
    /**
     * method edit quote
     * @param Request $request
     */
    public function editQuote(Request $request)
    {
        $id = $this->secure->decode((string) $request->xvalue);
        $quote = $id ? $this->quoteRepo->findById($id) : null;

        if (! $quote) {
            return [
                'success' => false,
                'message' => 'Quote not found',
                'code' => 404,
                'data' => null,
            ];
        }

        $data = [
            'xvalue' => $request->xvalue,
            'source_type' => $quote->source_type,
            'reference' => $quote->reference,
            'arabic_text' => $quote->arabic_text,
            'translation_text' => $quote->translation_text,
            'visibility' => $quote->visibility,
            'is_active' => (bool) $quote->is_active,
        ];

        return [
            'success' => true,
            'message' => 'data retrieved',
            'code' => 200,
            'data' => $data,
        ];
    }
    /**
     * method update quote
     * @param Request $request
     * @param User $user
     */
    public function updateQuote(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $quote = $id ? $this->quoteRepo->findById($id) : null;

            if (! $quote) {
                return [
                    'success' => false,
                    'message' => 'Quote not found',
                    'code' => 404,
                ];
            }

            $quote->update([
                'source_type' => $request->source_type,
                'reference' => $request->reference,
                'arabic_text' => $request->arabic_text,
                'translation_text' => $request->translation_text,
                'visibility' => $request->visibility,
                'is_active' => $request->boolean('is_active'),
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'UPDATE_QUOTE',
                $user->name . ' success update quote, id: ' . $id,
                $request
            );

            return [
                'success' => true,
                'message' => 'Quote updated successfully',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'UPDATE_QUOTE',
                $user->name . ' failed update quote, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed update quote, please try again or contact support',
                'code' => 500,
            ];
        }
    }
    /**
     * method change quote active/inactive status
     * @param Request $request
     * @param User $user
     */
    public function changeStatusQuote(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $quote = $id ? $this->quoteRepo->findById($id) : null;

            if (! $quote) {
                return [
                    'success' => false,
                    'message' => 'Quote not found',
                    'code' => 404,
                ];
            }

            $isActive = $request->boolean('is_active');

            if ($isActive) {
                $this->quoteRepo->setActive($quote->id);
            } else {
                $this->quoteRepo->setInActive($quote->id);
            }

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'CHANGE_STATUS_QUOTE',
                $user->name . ' set quote id ' . $quote->id . ' to ' . ($isActive ? 'active' : 'inactive'),
                $request
            );

            return [
                'success' => true,
                'message' => $isActive ? 'Quote activated' : 'Quote deactivated',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'CHANGE_STATUS_QUOTE',
                $user->name . ' failed change status quote, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
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
