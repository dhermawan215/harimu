<?php

namespace App\Repositories\package;

use App\Models\Package;

class PackageRepository
{
    private $isActive = 1;
    private $inActive = 0;
    private $truDelete = 1;
    private $falseDelete = 0;
    //method create nepavkeg
    public function createNewPackage(array $data)
    {
        return Package::create($data);
    }
    //method find data by id
    public function findById(int $id)
    {
        return Package::find($id);
    }
    //method make package active
    public function makePackageActive(int $id)
    {
        $query = Package::find($id);
        $query->update([
            'is_active' => $this->isActive
        ]);
    }
    //method make package inactive
    public function makePackageInActive(int $id)
    {
        $query = Package::find($id);
        $query->update([
            'is_active' => $this->inActive
        ]);
    }
    //method check slug uniqueness, optionally excluding a given package id (for update)
    public function isSlugTaken(string $slug, ?int $exceptId = null): bool
    {
        $query = Package::where('slug', $slug);

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }
}
