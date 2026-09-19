<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';
    protected $fillable = [
        'source_type',
        'reference',
        'arabic_text',
        'translation_text',
        'created_by',
        'visibility',
        'is_active',
        'is_delete',
    ];
}
