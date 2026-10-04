<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
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
                : asset('storage/' . $this->image);
        }

        return match ($this->slug) {
            'boating', 'water-activities' => asset('storage/activities/boating.png'),
            'foodtour', 'cooking' => asset('storage/activities/foodtour.png'),
            'motorbiketour', 'easy-rider', 'motorbike-self-drive' => asset('storage/activities/motorbiketour.png'),
            'trekking', 'trekking-hiking' => asset('storage/activities/trekking.jpg'),
            'caves-exploring' => asset('storage/activities/caves-exploring.jpg'),
            'sightseeing' => asset('storage/activities/sightseeing.jpg'),
            'cycling' => asset('storage/activities/motorbiketour.png'),
            default => asset('storage/activities/boating.png'),
        };
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class);
    }
}
