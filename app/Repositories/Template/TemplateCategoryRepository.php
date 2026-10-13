<?php

namespace App\Repositories\Template;

use App\Models\TemplateCategory;

class TemplateCategoryRepository
{
    /**
     * method created data
     * @param array $data
     */
    public function createData(array $data)
    {
        return TemplateCategory::create($data);
    }
    /**
     * method find single data
     * @param int $id
     */
    public function findData(int $id)
    {
        return TemplateCategory::find($id);
    }
    /**
     * method update data
     * @param int $id
     * @param array $data
     */
    public function updateData(int $id, array $data)
    {
        $query = $this->findData($id);
        return $query->update($data);
    }
    /**
     * method check slug uniqueness, optionally excluding a given category id (for update)
     * @param string $slug
     * @param int|null $exceptId
     */
    public function isSlugTaken(string $slug, ?int $exceptId = null): bool
    {
        $query = TemplateCategory::where('slug', $slug);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }
}
