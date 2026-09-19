<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';
    protected $fillable = [
        'template_category_id',
        'name',
        'slug',
        'thumbnail',
        'preview_url',
        'tier',
        'is_active',
        'created_by',
        'is_delete'
    ];
}
