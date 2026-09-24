<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_card_id')->constrained('wedding_cards')->onDelete('cascade');
            $table->string('guest_name');
            $table->string('phone')->nullable();
            $table->enum('side', ['groom', 'bride'])->default('groom');
            $table->boolean('is_attending')->nullable()->default(null);
            $table->integer('guest_count')->default(1);
            $table->foreignId('table_id')->nullable();
            $table->text('message')->nullable();
            $table->string('voice_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_rsvps');
    }
};