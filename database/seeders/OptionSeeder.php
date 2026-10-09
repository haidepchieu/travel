<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            // Thông tin chung & Liên hệ
            [
                'key' => 'site_name',
                'value' => 'Chestnut Travel',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Authentic Vietnam Tours & Experiences',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'site_hotline',
                'value' => '+84 867 216 850',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'site_whatsapp',
                'value' => '+84 867 216 850',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'site_whatsapp_link',
                'value' => 'https://wa.me/84867216850',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'site_email',
                'value' => 'info@chestnuttravel.net',
                'group' => 'contact',
                'type' => 'email',
            ],
            [
                'key' => 'site_address',
                'value' => '15 Cau Go Lane, Hang Bac Ward, Hoan Kiem District, Hanoi, Vietnam',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'working_hours',
                'value' => '07:30 - 22:00 (Monday - Sunday)',
                'group' => 'contact',
                'type' => 'text',
            ],

            // Thương hiệu & Hình ảnh (Logo, Favicon)
            [
                'key' => 'site_logo',
                'value' => 'site/logo.png',
                'group' => 'brand',
                'type' => 'image',
            ],
            [
                'key' => 'site_favicon',
                'value' => 'site/favicon.png',
                'group' => 'brand',
                'type' => 'image',
            ],
            [
                'key' => 'site_logo_url',
                'value' => '',
                'group' => 'brand',
                'type' => 'text',
            ],
            [
                'key' => 'site_favicon_url',
                'value' => '',
                'group' => 'brand',
                'type' => 'text',
            ],

            // Hero Banners Slider
            [
                'key' => 'hero_banners',
                'value' => json_encode([
                    [
                        'image' => 'banners/hero-1.jpg',
                        'image_url' => null,
                        'badge' => '#1 Authentic Local Travel in Northern Vietnam',
                        'title' => 'Your companion on every',
                        'title_highlight' => 'journey of discovery',
                        'subtitle' => 'Let Chestnut Travel be your trusted travel companion — conquering every spectacular road in Vietnam with you.',
                        'button_text' => 'Explore now',
                        'button_link' => '#tours-section',
                    ],
                    [
                        'image' => 'banners/hero-2.jpg',
                        'image_url' => null,
                        'badge' => 'Legendary Roads',
                        'title' => 'Discover the wonders of',
                        'title_highlight' => 'Ha Giang & Sa Pa',
                        'subtitle' => 'Conquer Ma Pi Leng Pass, the Nho Que River and breathtaking rice terraces.',
                        'button_text' => 'Xem tour hot',
                        'button_link' => '#tours-section',
                    ],
                ], JSON_UNESCAPED_UNICODE),
                'group' => 'banner',
                'type' => 'json',
            ],

            // Huy hiệu TripAdvisor & Điểm nổi bật
            [
                'key' => 'award_badge_image',
                'value' => 'badges/tcbr-2025.webp',
                'group' => 'badge',
                'type' => 'text',
            ],
            [
                'key' => 'award_badge_image_url',
                'value' => 'https://chestnuttravel.net/wp-content/uploads/2026/03/68924ea5265fcab08277e6f3_TCBR_green_BF_Logo_L_2025_RGB-170x170.webp',
                'group' => 'badge',
                'type' => 'text',
            ],
            [
                'key' => 'award_badge_title',
                'value' => 'Travellers\' Choice Award',
                'group' => 'badge',
                'type' => 'text',
            ],
            [
                'key' => 'award_badge_link',
                'value' => 'https://www.tripadvisor.com/Attraction_Review-g293924-d25178538-Reviews-Chestnut_Travel-Hanoi.html',
                'group' => 'badge',
                'type' => 'text',
            ],
            [
                'key' => 'award_badge_text',
                'value' => 'Chestnut Travel is proud to have been voted a Tripadvisor Travellers\' Choice 2025 winner by travelers from Vietnam and around the world!',
                'group' => 'badge',
                'type' => 'text',
            ],
            [
                'key' => 'feature_1_title',
                'value' => 'Local Travel Experts',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_1_desc',
                'value' => 'Our professional team knows the local culture inside out and is always ready to craft the perfect, most unique itinerary just for you.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_2_title',
                'value' => 'Best Price Guaranteed',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_2_desc',
                'value' => 'Transparent, all-inclusive pricing and a commitment to the best possible price for consistently high-quality service.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_3_title',
                'value' => '24/7 Customer Support',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_3_desc',
                'value' => 'Our customer care team is on hand 24/7 to support you and answer any questions before, during and after your trip.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'popular_trips_badge',
                'value' => 'Popular Trips',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'popular_trips_title',
                'value' => 'Explore our most loved tours.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'popular_trips_subtitle',
                'value' => 'Our most popular trips with carefully optimized itineraries and high-quality all-inclusive service.',
                'group' => 'features',
                'type' => 'text',
            ],

            // Ngân hàng & VietQR
            [
                'key' => 'site_bank_name',
                'value' => 'MB Bank (Military Commercial Joint Stock Bank)',
                'group' => 'banking',
                'type' => 'text',
            ],
            [
                'key' => 'site_bank_bin',
                'value' => 'MB',
                'group' => 'banking',
                'type' => 'text',
            ],
            [
                'key' => 'site_bank_account',
                'value' => '0334857689',
                'group' => 'banking',
                'type' => 'text',
            ],
            [
                'key' => 'site_bank_owner',
                'value' => 'CHESTNUT TRAVEL VN',
                'group' => 'banking',
                'type' => 'text',
            ],
            [
                'key' => 'site_bank_qr_image',
                'value' => 'options/01M404HZRB1A6W9VYHVB329KH1.png',
                'group' => 'banking',
                'type' => 'text',
            ],
            [
                'key' => 'site_bank_note',
                'value' => 'Please scan the QR code or make a bank transfer using your booking code as the reference (e.g. CNT-A1B2C3). Your booking will be reviewed and a confirmation email sent as soon as payment is received.',
                'group' => 'banking',
                'type' => 'text',
            ],

            // Mạng xã hội
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/chestnuttravel',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/chestnuttravel',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_tripadvisor',
                'value' => 'https://tripadvisor.com/chestnuttravel',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_tiktok',
                'value' => 'https://tiktok.com/@chestnuttravel',
                'group' => 'social',
                'type' => 'url',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@chestnuttravel',
                'group' => 'social',
                'type' => 'url',
            ],

            // Chân trang & Pháp lý
            [
                'key' => 'footer_about',
                'value' => 'Chestnut Travel is a tour operator specializing in authentic, unique experiences in Ha Giang, Sa Pa, Lan Ha Bay, Ninh Binh and other highland destinations in Northern Vietnam.',
                'group' => 'footer',
                'type' => 'textarea',
            ],
            [
                'key' => 'footer_license',
                'value' => 'International Tour Operator License No. 01-1898/2023/TCDL-GP LHQT issued by the Vietnam National Authority of Tourism',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'footer_copyright',
                'value' => '© 2026 Chestnut Travel. All rights reserved.',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'footer_payment_image_url',
                'value' => '',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'booking_modal_logo_url',
                'value' => '',
                'group' => 'brand',
                'type' => 'text',
            ],

            // Cấu hình Đặt tour
            [
                'key' => 'booking_notice',
                'value' => 'No sign-in required! You can book as a guest and the Chestnut team will contact you to confirm within 15 minutes.',
                'group' => 'booking',
                'type' => 'textarea',
            ],
            [
                'key' => 'child_discount_percent',
                'value' => '25',
                'group' => 'booking',
                'type' => 'number',
            ],
        ];

        foreach ($options as $item) {
            Option::updateOrCreate(
                ['key' => $item['key']],
                [
                    'value' => $item['value'],
                    'group' => $item['group'],
                    'type' => $item['type'],
                ]
            );
        }

        Option::clearCache();
    }
}
