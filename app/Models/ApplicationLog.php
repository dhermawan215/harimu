<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    protected $table='application_logs';
    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'event',
        'event_message',
        'user_agent',
        'url',
        'recorded_at'
    ];

    protected $casts = [
        'recorded_at'=>'datetime'
    ];
}
