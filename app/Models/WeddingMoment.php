<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\WeddingCard;
class WeddingMoment extends Model
{
    protected $fillable = [
        'wedding_card_id',
        'guest_name',
        'image',
        'is_approved',
    ];

    public function weddingCard(): BelongsTo
    {
        return $this->belongsTo(WeddingCard::class);
    }
}