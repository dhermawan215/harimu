<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    protected $table = 'user_packages';
    protected $fillable = [
        'user_id',
        'order_id',
        'package_id',
        'started_at',
        'expires_at',
        'invitations_used',
        'wa_blast_used',
        'status'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
