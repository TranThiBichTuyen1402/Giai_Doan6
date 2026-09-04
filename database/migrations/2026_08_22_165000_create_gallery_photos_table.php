<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_card_id')->constrained()->onDelete('cascade');
            $table->string('photo_url');
            $table->string('caption')->nullable();
            $table->string('uploaded_by')->default('Couple'); // 'Couple' (Cô dâu chú rể) hoặc tên 'Khách mời'
            $table->boolean('is_approved')->default(true); // Duyệt hiển thị (Default true cho couple, khách up có thể chờ duyệt)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
    }
};