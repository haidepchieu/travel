<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headerItems = [
            [
                'title' => 'Trang chủ',
                'url' => '/',
                'type' => 'link',
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Điểm đến',
                'url' => '#',
                'type' => 'destinations_dropdown', // Tự động load danh sách Điểm đến trong hệ thống
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Hoạt động',
                'url' => '#',
                'type' => 'activities_dropdown', // Tự động load danh sách Hoạt động trong hệ thống
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Combo Trọn gói',
                'url' => '/package',
                'type' => 'custom_dropdown',
                'badge' => 'Hot',
                'target' => '_self',
                'is_active' => true,
                'children' => [
                    [
                        'title' => 'Tất cả Gói Combo',
                        'subtitle' => 'Trọn gói tiết kiệm & trung chuyển liền mạch',
                        'url' => '/package',
                        'target' => '_self',
                    ],
                    [
                        'title' => 'Northern Vietnam Combo (6 Ngày)',
                        'subtitle' => 'Sa Pa, Hà Giang Loop & Ninh Bình',
                        'url' => '/package?region=north',
                        'target' => '_self',
                    ],
                    [
                        'title' => 'Middle Vietnam Combo (5 Ngày)',
                        'subtitle' => 'Huế, Hội An, Phong Nha & Đà Nẵng',
                        'url' => '/package?region=central',
                        'target' => '_self',
                    ],
                ],
            ],
            [
                'title' => 'Tùy chỉnh Tour',
                'url' => '/customized-tour',
                'type' => 'link',
                'badge' => 'Hot',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Blog & Tips',
                'url' => '/blog',
                'type' => 'link',
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Đánh giá',
                'url' => '/#reviews-section',
                'type' => 'link',
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Liên hệ',
                'url' => '#contact-footer',
                'type' => 'link',
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
        ];

        Menu::updateOrCreate(
            ['code' => 'header'],
            [
                'name' => 'Menu Chính (Header Navigation)',
                'items' => $headerItems,
                'is_active' => true,
            ]
        );
    }
}
