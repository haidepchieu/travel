<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourComboItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TourComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Schema::hasTable('tours') || !Schema::hasTable('tour_combo_items')) {
            return;
        }

        // Find available child tours to link
        $haGiangTour = Tour::where('slug', 'like', '%ha-giang%')->where('is_combo', false)->first();
        $sapaTour = Tour::where(function ($q) {
            $q->where('slug', 'like', '%sapa%')->orWhere('title', 'like', '%Sapa%');
        })->where('is_combo', false)->first();
        $ninhBinhTour = Tour::where(function ($q) {
            $q->where('slug', 'like', '%ninh-binh%')->orWhere('title', 'like', '%Ninh Binh%');
        })->where('is_combo', false)->first();

        // If specific tours don't exist, just get any other tours
        $fallbackTours = Tour::where('is_combo', false)->take(3)->get();
        if (!$haGiangTour && $fallbackTours->count() > 0) $haGiangTour = $fallbackTours->get(0);
        if (!$sapaTour && $fallbackTours->count() > 1) $sapaTour = $fallbackTours->get(1);
        if (!$ninhBinhTour && $fallbackTours->count() > 2) $ninhBinhTour = $fallbackTours->get(2);

        $northDest = Destination::where('slug', 'ha-giang')->orWhere('slug', 'hanoi')->first();

        $comboSlug = 'cultural-trekking-motor-riding-and-sight-seeing-6-day-sapa-ha-giang-ninh-binh-ethnic-immersion';
        
        $combo = Tour::firstOrNew(['slug' => $comboSlug]);
        $combo->title = 'Cultural Trekking, Motor Riding and Sight-seeing: 6-Day Sapa, Ha Giang & Ninh Binh Ethnic Immersion';
        $combo->tagline = 'Gói Combo khám phá trọn vẹn 3 kỳ quan miền Bắc: Sa Pa, Vòng cung Hà Giang và Tràng An Ninh Bình.';
        $combo->destination_id = $northDest?->id;
        $combo->duration_days = 6;
        $combo->duration_nights = 5;
        $combo->trip_type = 'Package Combo';
        $combo->difficulty = 'Medium';
        $combo->price = 459.00;
        $combo->sale_price = 399.00;
        $combo->is_combo = true;
        $combo->combo_badge = 'TIẾT KIỆM $60';
        $combo->combo_saving_amount = 60.00;
        $combo->is_featured = true;
        $combo->is_active = true;
        $combo->rating = 5.0;
        $combo->review_count = 18;
        $combo->highlights = [
            'Hành trình liên tỉnh xuyên suốt: Sa Pa - Hà Giang - Ninh Bình không lo tự đặt xe',
            'Chinh phục đỉnh đèo Mã Pí Lèng hùng vĩ và Hẻm vực Tu Sản sông Nho Quế',
            'Trekking bản làng người H\'Mông, Dao Đỏ tại Sa Pa và ngắm ruộng bậc thang',
            'Du thuyền nan trên dòng sông Ngô Đồng Tam Cốc - Bích Động di sản thế giới',
            'Toàn bộ xe trung chuyển limousine giường nằm cabin cao cấp đón trả tận nơi',
        ];
        $combo->inclusions = [
            'Toàn bộ vé xe limousine giường nằm cabin cao cấp liên tỉnh',
            'Xe máy đời mới kèm xăng và đồ bảo hộ phượt Hà Giang',
            'Hướng dẫn viên bản địa tiếng Anh chuyên nghiệp suốt tuyến',
            'Tất cả vé thắng cảnh, thuyền nan Tràng An / Tam Cốc',
            '5 đêm lưu trú khách sạn & homestay bản làng đặc sắc',
            'Các bữa ăn theo chương trình ẩm thực địa phương',
        ];
        $combo->exclusions = [
            'Đồ uống có cồn ngoài chương trình',
            'Tiền tip cho hướng dẫn viên và lái xe (tùy tâm)',
            'Chi tiêu mua sắm quà lưu niệm cá nhân',
        ];
        $combo->overview = '<h2>Hành trình khám phá trọn vẹn miền Bắc Việt Nam (6 Ngày 5 Đêm)</h2>
<p>Nếu bạn muốn tận hưởng trọn vẹn vẻ đẹp hoang sơ, hùng vĩ của vùng cao phía Bắc kết hợp với nét thanh bình non nước Tràng An mà không phải đau đầu lo việc mua vé xe, chuyển bến hay tự sắp xếp lịch trình, thì <strong>6-Day Sapa, Ha Giang & Ninh Binh Package Combo</strong> chính là lựa chọn hoàn hảo nhất.</p>
<p>Chuyến đi được điều phối liền mạch bởi Chestnut Travel, đưa bạn từ những thửa ruộng bậc thang kỳ vĩ của Sa Pa, vượt qua cung đường phượt huyền thoại Mã Pí Lèng tại Hà Giang, cho đến trải nghiệm chèo thuyền giữa lòng di sản văn hóa và thiên nhiên thế giới Tràng An (Ninh Bình).</p>';
        
        if (!$combo->featured_image && $haGiangTour?->featured_image) {
            $combo->featured_image = $haGiangTour->featured_image;
        }

        $combo->save();

        // Attach combo stages
        TourComboItem::where('parent_tour_id', $combo->id)->delete();

        $order = 1;
        if ($sapaTour) {
            TourComboItem::create([
                'parent_tour_id' => $combo->id,
                'child_tour_id' => $sapaTour->id,
                'stage_order' => $order++,
                'stage_title' => 'Chặng 1: Sa Pa - Trekking bản làng H\'Mông & Đỉnh Fansipan',
                'stage_days' => 2,
                'transit_notes' => 'Xe cabin VIP cao cấp đón lúc 21h00 tại Sa Pa di chuyển xuyên đêm sang TP Hà Giang (nghỉ ngơi trên xe)',
            ]);
        }

        if ($haGiangTour) {
            TourComboItem::create([
                'parent_tour_id' => $combo->id,
                'child_tour_id' => $haGiangTour->id,
                'stage_order' => $order++,
                'stage_title' => 'Chặng 2: Hà Giang Loop - Đèo Mã Pí Lèng, Đồng Văn & Sông Nho Quế',
                'stage_days' => 3,
                'transit_notes' => 'Xe Limousine đón tại Hà Giang đưa về Ninh Bình hoặc Hà Nội lúc 16h00',
            ]);
        }

        if ($ninhBinhTour) {
            TourComboItem::create([
                'parent_tour_id' => $combo->id,
                'child_tour_id' => $ninhBinhTour->id,
                'stage_order' => $order++,
                'stage_title' => 'Chặng 3: Ninh Bình - Thuyền nan Tam Cốc, Hang Múa & Cố đô Hoa Lư',
                'stage_days' => 1,
                'transit_notes' => 'Xe limousine đưa đón trả về lại Phố cổ Hà Nội lúc 18h30 kết thúc chuyến đi',
            ]);
        }
    }
}
