<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestBook extends Model
{
    protected $table = 'guest_books';
    protected $fillable = [
        'invitation_id',
        'guest_id',
        'name',
        'message',
        'attendance_status',
    ];

    //relationships to guest
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'id');
    }
    //relationships to invitation
    public function guestBookInvitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'id');
    }
}
