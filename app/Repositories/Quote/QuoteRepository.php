<?php

namespace App\Repositories\Quote;

use App\Models\Quote;

class QuoteRepository
{
    private $isActive = 1;
    private $inActive = 0;
    private $truDelete = 1;
    private $falseDelete = 0;
    //method create data
    public function createData(array $data)
    {
        return Quote::create($data);
    }
    //method find by id
    public function findById(int $id)
    {
        return Quote::find($id);
    }
    //method delete quote
    public function deleteDatas(array $ids)
    {
        $query = Quote::whereIn('id', $ids);
        $query->update([
            'is_delete' => $this->truDelete
        ]);
    }
    //method restore quote
    public function restoreDatas(array $ids)
    {
        $query = Quote::whereIn('id', $ids);
        $query->update([
            'is_delete' => $this->falseDelete
        ]);
    }
    //method make quote active
    public function setActive(int $id)
    {
        $query = Quote::find($id);
        $query->update(['is_active' => $this->isActive]);
    }
    //method make quote inactive
    public function setInActive(int $id)
    {
        $query = Quote::find($id);
        $query->update(['is_active' => $this->inActive]);
    }
    //method update data
    public function updateData(int $id, array $data)
    {
        $query = Quote::find($id);
        $query->update($data);
    }
}
