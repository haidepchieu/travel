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
                'value' => 'Số 15 Ngõ Cầu Gỗ, Phường Hàng Bạc, Quận Hoàn Kiếm, Hà Nội, Việt Nam',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'working_hours',
                'value' => '07:30 - 22:00 (Thứ 2 - Chủ Nhật)',
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
                        'badge' => '#1 Du Lịch Trải Nghiệm Bản Địa Tại Miền Bắc',
                        'title' => 'Đồng hành trên mọi',
                        'title_highlight' => 'hành trình khám phá',
                        'subtitle' => 'Để Chestnut Travel là người bạn đồng hành tin cậy — Cùng bạn chinh phục mọi cung đường kỳ vĩ của Việt Nam.',
                        'button_text' => 'Khám phá ngay',
                        'button_link' => '#tours-section',
                    ],
                    [
                        'image' => 'banners/hero-2.jpg',
                        'image_url' => null,
                        'badge' => 'Cung Đường Huyền Thoại',
                        'title' => 'Khám phá kỳ quan',
                        'title_highlight' => 'Hà Giang & Sa Pa',
                        'subtitle' => 'Chinh phục Mã Pí Lèng, sông Nho Quế và những thửa ruộng bậc thang kỳ vĩ.',
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
                'value' => 'Chứng nhận Travellers\' Choice',
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
                'value' => 'Chestnut Travel tự hào được cộng đồng du khách quốc tế và trong nước bình chọn trao tặng giải thưởng Travellers\' Choice 2025 từ Tripadvisor!',
                'group' => 'badge',
                'type' => 'text',
            ],
            [
                'key' => 'feature_1_title',
                'value' => 'Chuyên Gia Bản Địa',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_1_desc',
                'value' => 'Đội ngũ chuyên nghiệp, am hiểu sâu sắc văn hóa địa phương luôn sẵn sàng tư vấn lịch trình hoàn hảo và độc đáo nhất dành riêng cho bạn.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_2_title',
                'value' => 'Cam Kết Giá Tốt Nhất',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_2_desc',
                'value' => 'Chính sách giá minh bạch, trọn gói và cam kết mức giá tối ưu nhất tương xứng với chất lượng dịch vụ chuẩn mực.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_3_title',
                'value' => 'Hỗ Trợ Khách Hàng 24/7',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'feature_3_desc',
                'value' => 'Đội ngũ chăm sóc khách hàng luôn túc trực 24/7 đồng hành và hỗ trợ giải quyết mọi thắc mắc trước, trong và sau chuyến đi.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'popular_trips_badge',
                'value' => 'Hành Trình Nổi Bật',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'popular_trips_title',
                'value' => 'Khám phá các tour được yêu thích nhất.',
                'group' => 'features',
                'type' => 'text',
            ],
            [
                'key' => 'popular_trips_subtitle',
                'value' => 'Các chuyến đi được yêu thích nhất với lịch trình được tối ưu kỹ lưỡng và dịch vụ trọn gói chất lượng cao.',
                'group' => 'features',
                'type' => 'text',
            ],

            // Ngân hàng & VietQR
            [
                'key' => 'site_bank_name',
                'value' => 'MB Bank (Ngân hàng Quân Đội)',
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
                'value' => 'Vui lòng quét mã QR hoặc chuyển khoản với nội dung là Mã đơn đặt tour (VD: CNT-A1B2C3). Đơn hàng sẽ được quản trị viên duyệt và gửi email xác nhận ngay khi nhận được thanh toán.',
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
                'value' => 'Chestnut Travel là đơn vị lữ hành chuyên tổ chức các tour trải nghiệm nguyên bản, độc đáo tại Hà Giang, Sa Pa, Vịnh Lan Hạ, Ninh Bình và các điểm đến vùng cao phía Bắc Việt Nam.',
                'group' => 'footer',
                'type' => 'textarea',
            ],
            [
                'key' => 'footer_license',
                'value' => 'Giấy phép Lữ hành Quốc tế số: 01-1898/2023/TCDL-GP LHQT do Cục Du Lịch Quốc Gia Việt Nam cấp',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'footer_copyright',
                'value' => '© 2026 Chestnut Travel. Tất cả các quyền được bảo lưu.',
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
                'value' => 'Không bắt buộc đăng nhập! Bạn có thể đặt tour với tư cách Khách vãng lai, nhân viên Chestnut sẽ liên hệ xác nhận trong 15 phút.',
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
