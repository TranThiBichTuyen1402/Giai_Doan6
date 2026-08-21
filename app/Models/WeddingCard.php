<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\WeddingRsvp;
class WeddingCard extends Model
{
    use HasFactory;

    protected $table = 'wedding_cards';

  protected $fillable = [
    'template_id',
    'slug',

    'groom_name',
    'groom_phone',
    'groom_father',
    'groom_mother',
    'groom_avatar',
    'groom_bio',

    'bride_name',
    'bride_phone',
    'bride_father',
    'bride_mother',
    'bride_avatar',
    'bride_bio',

    'wedding_date',
    'lunar_date',
    'wedding_time',
    'wedding_location',
    'map_link',

    'invitation_msg',
    'cover_img',
    'album_imgs',
    'voice_invite',
    'voice_thanks',
    'bg_music',
    'wedding_video',
    'thank_msg',

    'time_welcome',
    'time_ceremony',
    'time_party',

    'groom_bank_name',
    'groom_bank_acc',
    'groom_bank_owner',

    'bride_bank_name',
    'bride_bank_acc',
    'bride_bank_owner',

    'user_id',
    'is_paid',
];

    // Tự động ép kiểu mảng cho album ảnh khi lấy dữ liệu ra hoặc lưu vào
    protected $casts = [
        'album_imgs' => 'array',
        'is_paid' => 'boolean',
    ];

public function user()
{
    return $this->belongsTo(User::class);
}
public function rsvps(): HasMany
{
   return $this->hasMany(WeddingRsvp::class, 'wedding_card_id');
}

}