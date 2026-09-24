<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';
    protected $fillable = [
        'title',
        'artist',
        'file_path',
        'duration',
        'tier',
        'is_active',
        'token',
        'is_delete',
    ];
}
