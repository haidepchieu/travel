<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'title',
        'author_name',
        'author_avatar',
        'author_location',
        'rating',
        'review_date',
        'comment',
        'source',
        'is_approved',
        'is_featured',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->author_avatar)) {
            return asset('storage/testimonials/lindsey-walker.png');
        }

        return \Illuminate\Support\Str::startsWith($this->author_avatar, ['http://', 'https://'])
            ? $this->author_avatar
            : asset('storage/' . ltrim($this->author_avatar, '/'));
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
