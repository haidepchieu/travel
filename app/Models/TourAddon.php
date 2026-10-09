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
                'name' => 'VIP Limousine transfer upgrade from the Old Quarter',
                'code' => 'limousine',
                'description' => 'Door-to-door hotel pickup with premium leather massage seats',
                'price' => 20.00,
                'price_unit' => '/person',
                'calculation_type' => 'per_person',
            ],
            [
                'id' => 2,
                'name' => 'Single Room Supplement',
                'code' => 'single_room',
                'description' => 'Upgrade from a shared dorm to a private homestay/hotel room',
                'price' => 25.00,
                'price_unit' => '/night',
                'calculation_type' => 'per_booking',
            ],
            [
                'id' => 3,
                'name' => 'Full motorbike damage insurance',
                'code' => 'motorbike_insurance',
                'description' => 'Covers scratches and damaged motorbike parts during the tour',
                'price' => 15.00,
                'price_unit' => '/bike',
                'calculation_type' => 'per_booking',
            ],
            [
                'id' => 4,
                'name' => 'Extra hotel night in the Old Quarter before the tour',
                'code' => 'hanoi_hotel',
                'description' => 'Deluxe room in central Hanoi Old Quarter to rest before departure',
                'price' => 30.00,
                'price_unit' => '/room',
                'calculation_type' => 'per_booking',
            ],
        ];
    }
}
