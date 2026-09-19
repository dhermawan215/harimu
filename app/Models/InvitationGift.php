<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationGift extends Model
{
    protected $table = 'invitation_gifts';

    protected $fillable = [
        'invitation_id',
        'type',
        'provider_name',
        'account_number',
        'account_holder_name',
        'qr_image',
        'shipping_address',
        'is_active',
        'sort_order',
    ];
}
