<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->string('author_name');
            $table->string('author_avatar')->nullable();
            $table->string('author_location')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('review_date')->nullable();
            $table->text('comment');
            $table->string('source')->default('Tripadvisor');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
