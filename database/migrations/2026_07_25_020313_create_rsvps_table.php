<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingRsvp extends Model
{
    // Sửa tên bảng cho khớp migration
    protected $table = 'wedding_rsvps';

    // Sửa các cột cho khớp với migration
    protected $fillable = [
        'wedding_card_id',
        'name',
        'side',
        'status',
        'guests',
        'note',
    ];

    public function weddingCard(): BelongsTo
    {
        return $this->belongsTo(WeddingCard::class, 'wedding_card_id');
    }
}