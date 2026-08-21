<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingTable extends Model
{
    use HasFactory;

    protected $table = 'tables';
    protected $fillable = ['wedding_card_id', 'name', 'capacity'];

    public function rsvps()
    {
        return $this->hasMany(WeddingRsvp::class, 'table_id');
    }
}