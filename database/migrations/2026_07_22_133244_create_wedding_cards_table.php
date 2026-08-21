<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('template_id')->default(1);
            $table->string('slug')->unique(); // Mã link thiệp
            
            // 1. Chú rể & Nhà trai
            $table->string('groom_name')->nullable();
            $table->string('groom_phone')->nullable();
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->string('groom_avatar')->nullable();
            $table->text('groom_bio')->nullable();

            // 2. Cô dâu & Nhà gái
            $table->string('bride_name')->nullable();
            $table->string('bride_phone')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->string('bride_avatar')->nullable();
            $table->text('bride_bio')->nullable();

            // 3. Thời gian & Địa điểm
            $table->string('wedding_date')->nullable();
            $table->string('lunar_date')->nullable();
            $table->string('wedding_time')->nullable();
            $table->string('wedding_location')->nullable();
            $table->text('map_link')->nullable();

            // 4. Nội dung & Media
            $table->text('invitation_msg')->nullable();
            $table->string('cover_img')->nullable();
            $table->json('album_imgs')->nullable();
            $table->string('voice_invite')->nullable();
            $table->string('voice_thanks')->nullable();
            $table->string('bg_music')->nullable();
            $table->string('wedding_video')->nullable();
            $table->text('thank_msg')->nullable();

            // 5. Lịch trình sự kiện
            $table->string('time_welcome')->nullable();
            $table->string('time_ceremony')->nullable();
            $table->string('time_party')->nullable();

            // 6. Mừng cưới Chú rể
            $table->string('groom_bank_name')->nullable();
            $table->string('groom_bank_acc')->nullable();
            $table->string('groom_bank_owner')->nullable();

            // 7. Mừng cưới Cô dâu
            $table->string('bride_bank_name')->nullable();
            $table->string('bride_bank_acc')->nullable();
            $table->string('bride_bank_owner')->nullable();

            // Trạng thái thanh toán
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_cards');
    }
};