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
            $table->string('package_option')->nullable()->after('tour_id');
            $table->string('departure_time')->nullable()->after('departure_date');
            $table->json('extra_services')->nullable()->after('special_requests');
            $table->string('payment_method')->nullable()->after('total_price');
            $table->string('payment_type')->default('full')->after('payment_method');
            $table->decimal('deposit_amount', 12, 2)->default(0)->after('payment_type');
            $table->decimal('remaining_amount', 12, 2)->default(0)->after('deposit_amount');
            $table->string('payment_transaction_id')->nullable()->after('remaining_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'package_option',
                'departure_time',
                'extra_services',
                'payment_method',
                'payment_type',
                'deposit_amount',
                'remaining_amount',
                'payment_transaction_id',
            ]);
        });
    }
};
