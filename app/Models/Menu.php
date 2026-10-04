<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'items',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get menu by code (e.g. 'header', 'footer')
     */
    public static function getByCode(string $code): ?self
    {
        return static::where('code', $code)->where('is_active', true)->first();
    }
}
