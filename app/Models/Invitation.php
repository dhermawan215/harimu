<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';
    protected $fillable = [
        'slug',
        'user_id',
        'user_package_id',
        'template_id',
        'music_id',
        'quote_id',
        'groom_name',
        'bride_name',
        'settings',
        'status',
        'is_delete',
        'published_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'published_at' => 'datetime',
    ];
}
