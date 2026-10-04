<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'title',
        'slug',
        'tagline',
        'overview',
        'featured_image',
        'gallery',
        'gallery_urls',
        'duration_days',
        'duration_nights',
        'trip_type',
        'departure_from',
        'transportation',
        'group_size',
        'difficulty',
        'price',
        'sale_price',
        'inclusions',
        'exclusions',
        'highlights',
        'faqs',
        'is_featured',
        'is_active',
        'is_combo',
        'combo_badge',
        'combo_saving_amount',
        'extra_services_mode',
        'rating',
        'review_count',
    ];

    protected $casts = [
        'gallery' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'highlights' => 'array',
        'faqs' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_combo' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'combo_saving_amount' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('order')->orderBy('day_number');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(TourPrice::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(TourBooking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function extraServices(): BelongsToMany
    {
        return $this->belongsToMany(TourAddon::class, 'extra_service_tour', 'tour_id', 'extra_service_id')
            ->withTimestamps();
    }

    public function comboItems(): HasMany
    {
        return $this->hasMany(TourComboItem::class, 'parent_tour_id')->orderBy('stage_order');
    }

    public function includedTours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_combo_items', 'parent_tour_id', 'child_tour_id')
            ->withPivot(['stage_order', 'stage_title', 'stage_days', 'transit_notes'])
            ->orderBy('tour_combo_items.stage_order');
    }

    public function parentCombos(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_combo_items', 'child_tour_id', 'parent_tour_id');
    }

    public function getComboOriginalPriceAttribute(): float
    {
        if (!$this->is_combo) {
            return (float) ($this->price ?? 0);
        }
        $total = 0;
        foreach ($this->includedTours as $child) {
            $total += (float) ($child->sale_price ?? $child->price ?? 0);
        }
        return $total > 0 ? $total : (float) ($this->price ?? 0);
    }

    public function getCalculatedSavingAttribute(): float
    {
        if ($this->combo_saving_amount && (float) $this->combo_saving_amount > 0) {
            return (float) $this->combo_saving_amount;
        }
        $orig = $this->combo_original_price;
        $curr = (float) ($this->sale_price ?? $this->price ?? 0);
        return max(0, $orig - $curr);
    }

    public function getAvailableAddonsAttribute()
    {
        $mode = $this->extra_services_mode ?? 'all';

        if ($mode === 'none') {
            return collect([]);
        }

        if ($mode === 'custom') {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('extra_service_tour')) {
                    return $this->extraServices()->where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
                }
            } catch (\Throwable $e) {}
        }

        // Mode 'all' or fallback
        try {
            $all = TourAddon::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
            if ($all->isNotEmpty()) {
                return $all;
            }
        } catch (\Throwable $e) {}

        return collect([]);
    }

    public function getReviewCountAttribute(): int
    {
        if (isset($this->attributes['reviews_count'])) {
            return (int) $this->attributes['reviews_count'];
        }
        if ($this->relationLoaded('reviews')) {
            return $this->reviews->where('is_approved', true)->count();
        }
        return $this->reviews()->where('is_approved', true)->count();
    }

    public function getAverageRatingAttribute(): float
    {
        if ($this->relationLoaded('reviews') && $this->reviews->where('is_approved', true)->count() > 0) {
            $avg = $this->reviews->where('is_approved', true)->avg('rating');
            return $avg ? round((float) $avg, 1) : 5.0;
        }
        $avg = $this->reviews()->where('is_approved', true)->avg('rating');
        return $avg ? round((float) $avg, 1) : (float) ($this->attributes['rating'] ?? 5.0);
    }

    public function getAllImagesAttribute(): array
    {
        $images = [];
        if (!empty($this->featured_image)) {
            $images[] = str_starts_with($this->featured_image, 'http')
                ? $this->featured_image
                : asset('storage/' . ltrim($this->featured_image, '/'));
        }
        if (is_array($this->gallery)) {
            foreach ($this->gallery as $img) {
                if ($img) {
                    $images[] = str_starts_with($img, 'http') ? $img : asset('storage/' . ltrim($img, '/'));
                }
            }
        }
        if (!empty($this->gallery_urls)) {
            $urls = preg_split('/[\r\n]+/', $this->gallery_urls);
            foreach ($urls as $url) {
                $url = trim($url);
                if (!empty($url)) {
                    $images[] = $url;
                }
            }
        }
        return array_values(array_unique($images));
    }
}
