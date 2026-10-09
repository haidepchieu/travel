<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            return \Illuminate\Support\Str::startsWith($this->image, ['http://', 'https://']) 
                ? $this->image 
                : asset('storage/' . ltrim($this->image, '/'));
        }

        return match ($this->slug) {
            'ha-giang' => asset('storage/destinations/ha-giang.jpg'),
            'ha-long-bay' => asset('storage/destinations/ha-long-bay.jpg'),
            'ninh-binh' => asset('storage/destinations/ninh-binh.jpg'),
            'sapa' => asset('storage/destinations/sapa.jpg'),
            'cat-ba-lan-ha-bay', 'lan-ha-bay' => asset('storage/destinations/lan-ha-bay.jpg'),
            'ta-xua' => asset('storage/destinations/ta-xua.jpg'),
            default => asset('storage/destinations/ha-giang.jpg'),
        };
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
