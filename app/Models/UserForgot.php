<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserForgot extends Model
{
    protected $table = 'user_forgots';
    protected $fillable = [
        'email',
        'token',
        'token_expired',
    ];

    protected $casts = [
        'token_expired' => 'datetime',
    ];
}
