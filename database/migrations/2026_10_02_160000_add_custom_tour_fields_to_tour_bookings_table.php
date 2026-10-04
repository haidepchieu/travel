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
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->foreignId('tour_id')->nullable()->change();
            $table->string('booking_type')->default('standard')->after('user_id'); // standard, enquiry, customized_tour
            $table->json('custom_details')->nullable()->after('special_requests'); // destinations, duration, hotel_type, activities, budget, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_type', 'custom_details']);
            $table->foreignId('tour_id')->nullable(false)->change();
        });
    }
};
