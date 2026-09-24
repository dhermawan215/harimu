<?php

namespace App\Repositories\Music;

use App\Models\Music;

class MusicRepository
{
    private $isActive = 1;
    private $inActive = 0;
    private $truDelete = 1;
    private $falseDelete = 0;

    public function createData(array $data)
    {
        return Music::create($data);
    }
    //method find data
    public function findActiveMusic(int $id)
    {
        $query = Music::where('is_delete', $this->falseDelete)
            ->where('id', $id);
        return $query->first();
    }
    //method find musics by ids
    public function findByIds(array $ids)
    {
        return Music::whereIn('id', $ids)->get();
    }
    //method delete music
    public function deleteDatas(array $ids)
    {
        $query = Music::whereIn('id', $ids);
        $query->update(['is_delete' => $this->truDelete]);
    }
    //method restore deleted music
    public function restoreDatas(array $ids)
    {
        $query = Music::whereIn('id', $ids);
        $query->update(['is_delete' => $this->falseDelete]);
    }
    //method make music active
    public function setMusicActive(int $id)
    {
        $query = Music::where('is_delete', $this->falseDelete)
            ->where('id', $id)->first();
        $query->update(['is_active' => $this->isActive]);
    }
    //method make music inactive
    public function setMusicInActive(int $id)
    {
        $query = Music::where('is_delete', $this->falseDelete)
            ->where('id', $id)->first();
        $query->update(['is_active' => $this->inActive]);
    }
    //method update data
    public function updateData(int $id, array $data)
    {
        $query = Music::find($id);
        $query->update($data);
    }
}
