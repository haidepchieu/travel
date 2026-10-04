<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->longText('overview')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->unsignedInteger('duration_days')->default(1);
            $table->unsignedInteger('duration_nights')->default(0);
            $table->string('trip_type')->nullable();
            $table->string('departure_from')->nullable();
            $table->string('transportation')->nullable();
            $table->string('group_size')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(5.0);
            $table->unsignedInteger('review_count')->default(0);
            $table->timestamps();
        });

        Schema::create('activity_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_tour');
        Schema::dropIfExists('tours');
    }
};
