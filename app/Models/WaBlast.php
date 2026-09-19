<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaBlast extends Model
{
    protected $table = 'wa_blasts';
    protected $fillable = [
        'invitation_id',
        'guest_id',
        'phone_number',
        'message_content',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
