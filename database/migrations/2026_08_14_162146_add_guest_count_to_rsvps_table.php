<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cột guest_count đã có sẵn trong bảng wedding_rsvps
    }

    public function down(): void
    {
        //
    }
};