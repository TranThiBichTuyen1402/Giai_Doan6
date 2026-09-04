<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_card_id',
        'sender_name',
        'message',
        'voice_url',
    ];

    public function weddingCard()
    {
        return $table->belongsTo(WeddingCard::class);
    }
}