<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationPhoto extends Model
{
    protected $table = 'invitation_photos';

    protected $fillable = [
        'invitation_id',
        'url',
        'type',
        'caption',
        'sort_order',
    ];
}
