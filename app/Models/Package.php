<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration_days',
        'max_invitations',
        'max_guests',
        'max_wa_blast',
        'template_tier',
        'is_active',
        'sort_order'
    ];
}
