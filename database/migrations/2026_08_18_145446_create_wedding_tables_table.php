<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_card_id')->constrained('wedding_cards')->onDelete('cascade');
            $table->string('name'); // Ví dụ: Bàn 01, Bàn Dự Phòng 01
            $table->string('group_name')->nullable(); // Cụm/Nhóm: Bạn Cấp 3, Họ Hàng Chú Rể,...
            $table->integer('capacity')->default(10); // Sức chứa tối đa (Thực tế ngồi)
            $table->integer('soft_capacity')->default(8); // Sức chứa xếp sẵn (Chừa 20% giảm xóc)
            $table->boolean('is_backup')->default(false); // Bàn dự phòng linh hoạt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_tables');
    }
};