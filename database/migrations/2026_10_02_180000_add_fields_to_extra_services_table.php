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
        if (!Schema::hasTable('extra_services')) {
            Schema::create('extra_services', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->string('price_unit')->default('/người');
                $table->string('calculation_type')->default('per_person'); // per_person hoặc per_booking
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('extra_services', function (Blueprint $table) {
                if (!Schema::hasColumn('extra_services', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('extra_services', 'code')) {
                    $table->string('code')->nullable()->after('name');
                }
                if (!Schema::hasColumn('extra_services', 'description')) {
                    $table->text('description')->nullable()->after('code');
                }
                if (!Schema::hasColumn('extra_services', 'price')) {
                    $table->decimal('price', 10, 2)->default(0)->after('description');
                }
                if (!Schema::hasColumn('extra_services', 'price_unit')) {
                    $table->string('price_unit')->default('/người')->after('price');
                }
                if (!Schema::hasColumn('extra_services', 'calculation_type')) {
                    $table->string('calculation_type')->default('per_person')->after('price_unit');
                }
                if (!Schema::hasColumn('extra_services', 'sort_order')) {
                    $table->integer('sort_order')->default(0)->after('calculation_type');
                }
                if (!Schema::hasColumn('extra_services', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('sort_order');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe down
    }
};
