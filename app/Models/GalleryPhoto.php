<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_card_id',
        'photo_url',
        'caption',
        'uploaded_by',
        'is_approved',
    ];
}