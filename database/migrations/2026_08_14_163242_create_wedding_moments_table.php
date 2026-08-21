<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_moments', function (Blueprint $table) {
            $table->id();

            // Thiệp mà khoảnh khắc này thuộc về
            $table->foreignId('wedding_card_id')
                  ->constrained('wedding_cards')
                  ->cascadeOnDelete();

            // Người gửi ảnh
            $table->string('guest_name')->nullable();

            // Đường dẫn ảnh
            $table->string('image');

            // Chờ duyệt / đã duyệt
            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_moments');
    }
};