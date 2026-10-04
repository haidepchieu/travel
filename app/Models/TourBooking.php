<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'booking_type',
        'tour_id',
        'package_option',
        'customer_name',
        'customer_email',
        'customer_phone',
        'departure_date',
        'departure_time',
        'adults',
        'children',
        'hotel_pickup',
        'special_requests',
        'custom_details',
        'extra_services',
        'total_price',
        'payment_method',
        'payment_type',
        'deposit_amount',
        'remaining_amount',
        'payment_transaction_id',
        'payment_status',
        'booking_status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'custom_details' => 'array',
        'extra_services' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                do {
                    $code = 'CNT-' . strtoupper(\Illuminate\Support\Str::random(7));
                } while (static::where('booking_code', $code)->exists());
                $booking->booking_code = $code;
            }
        });
    }
}
