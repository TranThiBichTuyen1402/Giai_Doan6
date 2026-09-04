<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('wishes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('wedding_card_id')->constrained('wedding_cards')->onDelete('cascade');
        $table->string('sender_name');
        $table->text('message')->nullable();
        $table->string('voice_url')->nullable(); // Đường dẫn file âm thanh voice (nếu có)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishes');
    }
};
