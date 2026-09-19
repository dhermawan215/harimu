<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
        'invitation_id',
        'name',
        'phone_number',
        'group_name',
        'unique_code',
        'rsvp_status',
        'rsvp_count',
        'rsvp_at',
    ];
    //relationships to invitation
    public function guestInvitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'id');
    }
    //relationships to guest book
    public function guestBook(): HasOne
    {
        return $this->hasOne(GuestBook::class, 'guest_id', 'id');
    }
}
