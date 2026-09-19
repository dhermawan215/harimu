<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaBlastTemplate extends Model
{
    protected $table = 'wa_blast_templates';
    protected $fillable = [
        'user_id',
        'name',
        'content',
        'is_default',
    ];
}
