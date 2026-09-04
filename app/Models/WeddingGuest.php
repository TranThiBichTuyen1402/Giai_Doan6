<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingGuest extends Model
{
    use HasFactory;

    protected $table = 'wedding_guests';

    protected $fillable = [
        'wedding_card_id',
        'wedding_table_id',
        'name',
        'plus_ones',
        'note',
        'status',
    ];

    public function weddingCard(): BelongsTo
    {
        return $this->belongsTo(WeddingCard::class, 'wedding_card_id');
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(WeddingTable::class, 'wedding_table_id');
    }
}