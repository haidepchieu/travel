<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
        });

        Schema::table('tour_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('tour_bookings', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('booking_code')->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('tour_bookings', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
