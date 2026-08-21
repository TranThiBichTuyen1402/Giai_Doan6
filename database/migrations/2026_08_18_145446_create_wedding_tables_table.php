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
    Schema::create('tables', function (Blueprint $table) {
        $table->id();
        $table->foreignId('wedding_card_id')->constrained('wedding_cards')->onDelete('cascade');
        $table->string('name'); // Tên bàn: Bàn 01, Bàn Cấp 3, Bàn VIP...
        $table->string('location')->nullable(); // Khu vực: Sảnh A, Tầng 1, Nhà gái...
        $table->integer('capacity')->default(10); // Số ghế tối đa
        $table->timestamps();
    });

    // Thêm cột table_id vào bảng rsvps (nếu chưa có) để gán khách vào bàn
    Schema::table('rsvps', function (Blueprint $table) {
        $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_tables');
    }
};
