<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationEvent extends Model
{
    protected $table = 'invitation_events';
    protected $fillable = [
        'invitation_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'venue_name',
        'address',
        'gmaps_url',
        'sort_order',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time',
    ];
}
