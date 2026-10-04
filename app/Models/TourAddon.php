<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAddon extends Model
{
    use HasFactory;

    protected $table = 'extra_services';

    protected $fillable = [
        'name',
        'code',
        'description',
        'price',
        'price_unit',
        'calculation_type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function tours(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'extra_service_tour', 'extra_service_id', 'tour_id')
            ->withTimestamps();
    }

    public static function defaultServices(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Nâng cấp xe Limousine VIP đưa đón Phố Cổ',
                'code' => 'limousine',
                'description' => 'Đưa đón tận cửa khách sạn, ghế massage bọc da cao cấp',
                'price' => 20.00,
                'price_unit' => '/người',
                'calculation_type' => 'per_person',
            ],
            [
                'id' => 2,
                'name' => 'Phòng riêng tư (Single Room Supplement)',
                'code' => 'single_room',
                'description' => 'Nâng cấp từ phòng dorm tập thể lên phòng riêng homestay/khách sạn',
                'price' => 25.00,
                'price_unit' => '/đêm',
                'calculation_type' => 'per_booking',
            ],
            [
                'id' => 3,
                'name' => 'Bảo hiểm toàn diện sự cố xe máy',
                'code' => 'motorbike_insurance',
                'description' => 'Miễn trừ bồi thường trầy xước, hỏng hóc phụ tùng xe máy khi đi tour',
                'price' => 15.00,
                'price_unit' => '/xe',
                'calculation_type' => 'per_booking',
            ],
            [
                'id' => 4,
                'name' => 'Thêm 1 đêm khách sạn Phố Cổ trước tour',
                'code' => 'hanoi_hotel',
                'description' => 'Phòng Deluxe trung tâm Phố Cổ Hà Nội tiện nghỉ ngơi trước giờ xe chạy',
                'price' => 30.00,
                'price_unit' => '/phòng',
                'calculation_type' => 'per_booking',
            ],
        ];
    }
}
