<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\WeddingTable;

class WeddingRsvp extends Model
{
    // SỬA CHÍNH XÁC TÊN BẢNG TẠI ĐÂY:
    protected $table = 'wedding_rsvps';

    protected $fillable = [
        'wedding_card_id',
        'table_id',
        'guest_name',
        'side',
        'guest_count',
        'phone',
        'message',
        'is_attending',
    ];

    protected $casts = [
        'is_attending' => 'boolean',
        'guest_count' => 'integer',
    ];

    public function weddingCard(): BelongsTo
    {
        return $this->belongsTo(WeddingCard::class);
    }

    public function table()
    {
        return $this->belongsTo(WeddingTable::class, 'table_id');
    }
}