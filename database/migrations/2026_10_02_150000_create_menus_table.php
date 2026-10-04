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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên menu (ví dụ: Menu Chính Header, Menu Footer)
            $table->string('code')->unique(); // Mã vị trí hiển thị: 'header' hoặc 'footer' (tránh nhầm lẫn với điểm đến)
            $table->json('items')->nullable(); // Danh sách các mục menu (tên, link, loại, thứ tự)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
