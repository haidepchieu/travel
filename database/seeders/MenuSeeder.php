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
                'title' => 'Home',
                'url' => '/',
                'type' => 'link',
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Destinations',
                'url' => '#',
                'type' => 'destinations_dropdown', // Tự động load danh sách Điểm đến trong hệ thống
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Activities',
                'url' => '#',
                'type' => 'activities_dropdown', // Tự động load danh sách Hoạt động trong hệ thống
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Package Combos',
                'url' => '/package',
                'type' => 'custom_dropdown',
                'badge' => 'Hot',
                'target' => '_self',
                'is_active' => true,
                'children' => [
                    [
                        'title' => 'All Package Combos',
                        'subtitle' => 'All-inclusive savings & seamless transfers',
                        'url' => '/package',
                        'target' => '_self',
                    ],
                    [
                        'title' => 'Northern Vietnam Combo (6 Days)',
                        'subtitle' => 'Sa Pa, Ha Giang Loop & Ninh Binh',
                        'url' => '/package?region=north',
                        'target' => '_self',
                    ],
                    [
                        'title' => 'Middle Vietnam Combo (5 Days)',
                        'subtitle' => 'Hue, Hoi An, Phong Nha & Da Nang',
                        'url' => '/package?region=central',
                        'target' => '_self',
                    ],
                ],
            ],
            [
                'title' => 'Customize Tour',
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
                'title' => 'Reviews',
                'url' => '/#reviews-section',
                'type' => 'link',
                'badge' => '',
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Contact',
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
                'name' => 'Main Menu (Header Navigation)',
                'items' => $headerItems,
                'is_active' => true,
            ]
        );
    }
}
