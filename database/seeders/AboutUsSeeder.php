<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = <<<'HTML'
<div class="space-y-6">
    <!-- Intro Highlights Callout -->
    <div class="bg-gradient-to-r from-teal-50 to-emerald-50 border-l-4 border-[#26786e] p-5 sm:p-6 rounded-r-2xl shadow-sm">
        <p class="text-sm sm:text-base font-semibold text-teal-900 leading-relaxed italic mb-0">
            "Handling all your travel issues — Experience travel with trust and comfort, let us make your journey memorable."
        </p>
        <span class="block text-xs font-bold text-[#26786e] uppercase tracking-wider mt-2">— Đội ngũ sáng lập Chestnut Travel</span>
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight pt-2">
        1. Về Chestnut Travel — Khởi Nguồn Từ Đam Mê Khám Phá
    </h2>

    <p class="text-gray-700 leading-relaxed">
        Chào mừng bạn đến với <strong>Chestnut Travel</strong>, người bạn đồng hành tin cậy trên hành trình khám phá vẻ đẹp kỳ vĩ và chiều sâu văn hóa của đất nước Việt Nam. Trụ sở tại trung tâm Phố Cổ Hà Nội ngàn năm văn hiến, chúng tôi là tập thể những người con đất Việt trẻ tuổi, nhiệt huyết và am hiểu sâu sắc từng tấc đất quê hương.
    </p>

    <p class="text-gray-700 leading-relaxed">
        Tại Chestnut Travel, chúng tôi thấu hiểu rằng mỗi du khách đều mang trong mình những sở thích, mong đợi và phong cách du lịch riêng biệt. Đó là lý do chúng tôi không đơn thuần bán những tour du lịch cố định, mà luôn lắng nghe để mang lại những <strong>hành trình may đo độc bản (Customized Tour)</strong>, từ những chuyến nghỉ dưỡng êm đềm bên vịnh biển ngọc bích đến những cung đường phượt xe máy đầy mê hoặc giữa đại ngàn Đông Bắc.
    </p>

    <!-- Tripadvisor Choice Banner -->
    <div class="my-8 p-6 bg-[#26786e]/5 border border-[#26786e]/20 rounded-2xl flex flex-col sm:flex-row items-center gap-5">
        <img src="https://chestnuttravel.net/wp-content/uploads/2026/03/68924ea5265fcab08277e6f3_TCBR_green_BF_Logo_L_2025_RGB-170x170.webp" 
             alt="Tripadvisor Travellers Choice" class="w-20 h-20 object-contain shrink-0">
        <div>
            <span class="text-xs font-extrabold uppercase text-[#26786e] tracking-wider">Chứng nhận danh giá</span>
            <h4 class="text-lg font-bold text-gray-900">Tripadvisor Travellers' Choice Award 2025</h4>
            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                Chúng tôi vinh dự nhận giải thưởng Travellers' Choice từ cộng đồng du lịch quốc tế TripAdvisor, ghi nhận sự hài lòng vượt bậc của hàng ngàn du khách trên toàn thế giới đã đồng hành cùng Chestnut Travel.
            </p>
        </div>
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight pt-2">
        2. Bốn Giá Trị Cốt Lõi Tạo Nên Sự Khác Biệt
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-teal-100 text-[#26786e] flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">Chuyên gia bản địa (Local Experts)</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Đội ngũ hướng dẫn viên và tài xế Easy Rider sinh ra và lớn lên tại địa phương. Chúng tôi đưa bạn đến những góc ngắm cảnh bí mật, thưởng thức ẩm thực gốc và giao lưu chân thành cùng người dân bản địa.
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">Cam kết giá tốt nhất (Best Price)</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Chestnut Travel làm việc trực tiếp với các nhà xe limousine, du thuyền, khách sạn và homestay gia đình, mang đến chi phí tối ưu nhất mà không qua bất kỳ khâu trung gian nào.
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-headset"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">Hỗ trợ 24/7 (Always By Your Side)</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Đội ngũ chăm sóc khách hàng túc trực 24/7 qua WhatsApp, Hotline và Zalo. Chúng tôi chủ động theo sát hành trình để đảm bảo mọi phát sinh đều được giải quyết êm đẹp.
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">An toàn & Bảo hiểm trọn gói</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Mọi chuyến đi đều được trang bị mũ bảo hiểm đạt chuẩn, phương tiện vận tải đời mới kiểm định nghiêm ngặt và gói bảo hiểm du lịch toàn diện cho mọi hành khách.
            </p>
        </div>
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight pt-2">
        3. Các Dịch Vụ Du Lịch Tiêu Biểu
    </h2>

    <ul class="space-y-3 text-gray-700 text-sm sm:text-base leading-relaxed pl-2">
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Ha Giang Loop Tour:</strong> Khám phá cung đường đèo huyền thoại Mã Pí Lèng, sông Nho Quế, hẻm Tu Sản bằng xe máy cùng Easy Rider hoặc xe du lịch VIP.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Sa Pa Trekking & Bản làng:</strong> Chinh phục đỉnh Fansipan nóc nhà Đông Dương, trekking qua thung lũng Mường Hoa, Tả Van, Ý Linh Hồ.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Du thuyền Vịnh Lan Hạ & Cát Bà:</strong> Trải nghiệm du thuyền boutique sang trọng, chèo kayak qua hang Sáng Tối và đắm mình trong làn nước ngọc bích.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Ninh Bình Di Sản Thế Giới:</strong> Đi thuyền Tràng An, Tam Cốc Bích Động, ngắm toàn cảnh non nước từ đỉnh Hang Múa.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Customized Tour (Tour Thiết Kế Riêng):</strong> Xây dựng lịch trình theo từng yêu cầu gia đình, cơ quan, nhóm bạn bè với mức giá tối ưu nhất.</span>
        </li>
    </ul>

    <!-- Legal & Contact Box -->
    <div class="mt-8 p-6 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
            <i class="fa-solid fa-building-columns text-[#26786e]"></i>
            Thông Tin Doanh Nghiệp & Giấy Phép Hoạt Động
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-600 pt-2">
            <div>
                <strong>Tên thương hiệu:</strong> Chestnut Travel
            </div>
            <div>
                <strong>Giấy phép Lữ hành Quốc tế:</strong> Số 01-1898/2023/TCDL-GP LHQT
            </div>
            <div>
                <strong>Địa chỉ văn phòng:</strong> 95h Lý Nam Đế, Cửa Đông, Hoàn Kiếm, Hà Nội
            </div>
            <div>
                <strong>Hotline / WhatsApp:</strong> +84 867 216 850
            </div>
            <div>
                <strong>Email hỗ trợ:</strong> info@chestnuttravel.net
            </div>
            <div>
                <strong>Thời gian làm việc:</strong> 07:30 - 22:00 (Hàng ngày)
            </div>
        </div>
    </div>
</div>
HTML;

        // Create or update About Us article
        Post::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'Về Chúng Tôi — Giới Thiệu Chestnut Travel',
                'category' => 'Về Chúng Tôi',
                'excerpt' => 'Chestnut Travel là đơn vị lữ hành uy tín hàng đầu tại Hà Nội, chuyên cung cấp các tour du lịch trải nghiệm bản địa độc bản, chinh phục Hà Giang Loop, Sa Pa, Vịnh Lan Hạ, Ninh Bình và khắp miền đất nước Việt Nam.',
                'featured_image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1600&q=85',
                'author_name' => 'Chestnut Travel Team',
                'tags' => ['About Us', 'Giới thiệu', 'Chestnut Travel', 'Du lịch Việt Nam'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::now(),
                'views_count' => 128,
                'content' => $content,
            ]
        );

        // Also add or update Giới thiệu in Header Menu if not present
        $menu = Menu::where('code', 'header')->first();
        if ($menu && is_array($menu->items)) {
            $items = $menu->items;
            $hasAbout = false;
            foreach ($items as $it) {
                if (($it['url'] ?? '') === '/about-us' || ($it['title'] ?? '') === 'Giới thiệu') {
                    $hasAbout = true;
                    break;
                }
            }

            if (!$hasAbout) {
                // Insert 'Giới thiệu' right after 'Trang chủ' (at index 1)
                $newItem = [
                    'title' => 'Giới thiệu',
                    'url' => '/about-us',
                    'type' => 'link',
                    'badge' => '',
                    'target' => '_self',
                    'is_active' => true,
                ];

                array_splice($items, 1, 0, [$newItem]);
                $menu->items = $items;
                $menu->save();
            }
        }
    }
}
