<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingTable extends Model
{
    use HasFactory;

    protected $table = 'wedding_tables';

    protected $fillable = [
        'wedding_card_id',
        'name',
        'capacity',
    ];

    /**
     * Khai báo mối quan hệ 1 Bàn Tiệc có nhiều Khách RSVP
     */
    public function rsvps()
    {
        return $this->hasMany(WeddingRsvp::class, 'table_id', 'id');
    }
}