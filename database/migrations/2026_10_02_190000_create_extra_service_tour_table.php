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
        if (Schema::hasTable('tours') && !Schema::hasColumn('tours', 'extra_services_mode')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->string('extra_services_mode')->default('all')->after('is_active');
            });
        }

        if (!Schema::hasTable('extra_service_tour')) {
            Schema::create('extra_service_tour', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
                $table->foreignId('extra_service_id')->constrained('extra_services')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['tour_id', 'extra_service_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_service_tour');

        if (Schema::hasTable('tours') && Schema::hasColumn('tours', 'extra_services_mode')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->dropColumn('extra_services_mode');
            });
        }
    }
};
