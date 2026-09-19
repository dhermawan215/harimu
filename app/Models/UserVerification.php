<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $table = 'user_verifications';
    protected $fillable = [
        'email',
        'token',
        'token_expired',
    ];

    protected $casts = [
        'token_expired' => 'datetime',
    ];
}
