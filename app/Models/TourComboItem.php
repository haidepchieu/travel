<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourComboItem extends Model
{
    use HasFactory;

    protected $table = 'tour_combo_items';

    protected $fillable = [
        'parent_tour_id',
        'child_tour_id',
        'stage_order',
        'stage_title',
        'stage_days',
        'transit_notes',
    ];

    protected $casts = [
        'stage_order' => 'integer',
        'stage_days' => 'integer',
    ];

    public function parentTour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'parent_tour_id');
    }

    public function childTour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'child_tour_id');
    }
}
