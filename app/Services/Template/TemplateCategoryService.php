<?php

namespace App\Services\Template;

use App\Contracts\Template\TemplateCategoryInterface;
use App\Logs\HansLogging;
use App\Models\User;
use App\Repositories\Template\TemplateCategoryRepository;
use HansCrypt\Contract\SecureEncryptionInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateCategoryService implements TemplateCategoryInterface
{
    use HansLogging;
    protected SecureEncryptionInterface $secure;
    protected TemplateCategoryRepository $templateRepo;

    public function __construct(
        TemplateCategoryRepository $templateCategoryRepository,
        SecureEncryptionInterface $secureEncryptionInterface
    ) {
        $this->templateRepo = $templateCategoryRepository;
        $this->secure = $secureEncryptionInterface;
    }

    /**
     * method generate a slug from the category name, guaranteed unique
     * @param string $name
     * @param int|null $exceptId category id to ignore during the uniqueness check (used on update)
     */
    protected function generateSlug(string $name, ?int $exceptId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 1;

        while ($this->templateRepo->isSlugTaken($slug, $exceptId)) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        return $slug;
    }
    /**
     * method save template category
     * @param Request $request
     * @param User $user
     */
    public function saveCategory(Request $request, User $user)
    {
        try {
            $this->templateRepo->createData([
                'name' => $request->name,
                'slug' => $this->generateSlug($request->name),
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'SAVE_TEMPLATE_CATEGORY',
                $user->name . ' success save template category',
                $request
            );

            return [
                'success' => true,
                'message' => 'Template category saved successfully',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'SAVE_TEMPLATE_CATEGORY',
                $user->name . ' failed save template category, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed save template category, please try again or contact support',
                'code' => 500,
            ];
        }
    }
    /**
     * method edit template category
     * @param Request $request
     */
    public function editCategory(Request $request)
    {
        $id = $this->secure->decode((string) $request->xvalue);
        $category = $id ? $this->templateRepo->findData($id) : null;

        if (! $category) {
            return [
                'success' => false,
                'message' => 'Template category not found',
                'code' => 404,
                'data' => null,
            ];
        }

        $data = [
            'xvalue' => $request->xvalue,
            'name' => $category->name,
            'slug' => $category->slug,
        ];

        return [
            'success' => true,
            'message' => 'data retrieved',
            'code' => 200,
            'data' => $data,
        ];
    }
    /**
     * method update template category
     * @param Request $request
     * @param User $user
     */
    public function updateCategory(Request $request, User $user)
    {
        try {
            $id = $this->secure->decode((string) $request->xvalue);
            $category = $id ? $this->templateRepo->findData($id) : null;

            if (! $category) {
                return [
                    'success' => false,
                    'message' => 'Template category not found',
                    'code' => 404,
                ];
            }

            $slug = $category->name === $request->name
                ? $category->slug
                : $this->generateSlug($request->name, $category->id);

            $this->templateRepo->updateData($category->id, [
                'name' => $request->name,
                'slug' => $slug,
            ]);

            $this->captureApplicationLog(
                $user->id,
                $user->email,
                'UPDATE_TEMPLATE_CATEGORY',
                $user->name . ' success update template category, id: ' . $id,
                $request
            );

            return [
                'success' => true,
                'message' => 'Template category updated successfully',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            $this->captureSystemLog(
                $user->id ?? null,
                $user->email,
                'UPDATE_TEMPLATE_CATEGORY',
                $user->name . ' failed update template category, because have an error: ' . $th->getMessage() . ' on file: ' . $th->getFile() . ' line: ' . $th->getLine(),
                $request
            );

            return [
                'success' => false,
                'message' => 'Failed update template category, please try again or contact support',
                'code' => 500,
            ];
        }
    }
}
