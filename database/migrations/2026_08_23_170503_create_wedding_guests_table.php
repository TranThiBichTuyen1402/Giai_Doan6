<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_card_id')->constrained('wedding_cards')->onDelete('cascade');
            $table->foreignId('wedding_table_id')->nullable()->constrained('wedding_tables')->onDelete('set null');
            $table->string('name'); // Tên khách mời
            $table->integer('plus_ones')->default(0); // Số người đi kèm (+1, +2)
            $table->string('note')->nullable(); // Ghi chú (VD: Lớp trưởng C3, Cậu Hai,...)
            $table->enum('status', ['pending', 'confirmed', 'declined'])->default('pending'); // Trạng thái
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_guests');
    }
};