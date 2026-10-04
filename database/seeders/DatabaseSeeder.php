<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Toàn bộ dữ liệu tour, điểm đến, lịch trình và cài đặt được quản trị trực tiếp trong MySQL Database.
     */
    public function run(): void
    {
        // 1. Tạo tài khoản quản trị Admin mặc định nếu chưa tồn tại
        User::firstOrCreate(
            ['email' => 'admin@chestnuttravel.net'],
            [
                'name' => 'Admin Chestnut',
                'phone' => '+84867216850',
                'password' => bcrypt('admin123'),
            ]
        );

        // 2. Cài đặt các thiết lập mặc định (Website Settings)
        $this->call(OptionSeeder::class);

        // 3. Khởi tạo bài viết mẫu Blog & Tips
        $this->call(PostSeeder::class);

        // 4. Khởi tạo gói Tour Combo mẫu
        $this->call(TourComboSeeder::class);
    }
}
