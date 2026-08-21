<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wedding_cards', function (Blueprint $table) {
            if (!Schema::hasColumn('wedding_cards', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('wedding_cards', 'is_vip')) {
                $table->boolean('is_vip')->default(false)->after('user_id'); // 0: Free, 1: VIP
            }
            if (!Schema::hasColumn('wedding_cards', 'vip_expires_at')) {
                $table->timestamp('vip_expires_at')->nullable()->after('is_vip'); // Thời hạn VIP nếu có
            }
            if (!Schema::hasColumn('wedding_cards', 'first_published_at')) {
                $table->timestamp('first_published_at')->nullable()->after('vip_expires_at'); // Mốc tính 24h chỉnh sửa cho Free
            }
        });
    }

    public function down(): void
    {
        Schema::table('wedding_cards', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'is_vip', 'vip_expires_at', 'first_published_at']);
        });
    }
};