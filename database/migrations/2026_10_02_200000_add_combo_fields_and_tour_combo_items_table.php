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
        // 1. Add combo fields to tours table
        Schema::table('tours', function (Blueprint $table) {
            if (!Schema::hasColumn('tours', 'is_combo')) {
                $table->boolean('is_combo')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('tours', 'combo_badge')) {
                $table->string('combo_badge')->nullable()->after('is_combo');
            }
            if (!Schema::hasColumn('tours', 'combo_saving_amount')) {
                $table->decimal('combo_saving_amount', 10, 2)->nullable()->after('combo_badge');
            }
        });

        // 2. Create tour_combo_items table to link combo parent tour with child tours
        if (!Schema::hasTable('tour_combo_items')) {
            Schema::create('tour_combo_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_tour_id')->constrained('tours')->cascadeOnDelete();
                $table->foreignId('child_tour_id')->constrained('tours')->cascadeOnDelete();
                $table->unsignedInteger('stage_order')->default(1);
                $table->string('stage_title')->nullable();
                $table->unsignedInteger('stage_days')->default(1);
                $table->text('transit_notes')->nullable();
                $table->timestamps();

                $table->index(['parent_tour_id', 'stage_order']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_combo_items');

        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'combo_saving_amount')) {
                $table->dropColumn('combo_saving_amount');
            }
            if (Schema::hasColumn('tours', 'combo_badge')) {
                $table->dropColumn('combo_badge');
            }
            if (Schema::hasColumn('tours', 'is_combo')) {
                $table->dropColumn('is_combo');
            }
        });
    }
};
