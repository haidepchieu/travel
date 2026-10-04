<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    use HasFactory;

    protected $table = 'options';

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    /**
     * Cache key for all options
     */
    const CACHE_KEY = 'all_site_options';

    /**
     * Get an option value by key
     */
    public static function get(string $key, $default = null)
    {
        $all = static::getAllCached();
        return $all[$key] ?? $default;
    }

    /**
     * Get JSON decoded option value
     */
    public static function getJson(string $key, array $default = []): array
    {
        $val = static::get($key);
        if (empty($val)) {
            return $default;
        }
        if (is_array($val)) {
            return $val;
        }
        $decoded = json_decode($val, true);
        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * Set / update an option value
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'text'): self
    {
        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            $type = 'json';
        }

        $option = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        static::clearCache();

        return $option;
    }

    /**
     * Get image URL for an option key (handles both uploaded files, custom URL fields, and external URLs)
     */
    public static function getImageUrl(string $key, ?string $default = null): ?string
    {
        $val = static::get($key);
        $urlVal = static::get($key . '_url');

        if ($default === null) {
            if ($key === 'site_logo') {
                $default = asset('storage/site/logo.png');
            } elseif ($key === 'site_favicon') {
                $default = asset('storage/site/favicon.png');
            }
        }

        // Prefer uploaded file if present, else custom URL, else default
        $chosen = !empty($val) ? $val : (!empty($urlVal) ? $urlVal : $default);

        if (empty($chosen)) {
            return null;
        }

        if (str_starts_with($chosen, 'http://') || str_starts_with($chosen, 'https://') || str_starts_with($chosen, '//')) {
            return $chosen;
        }

        return asset('storage/' . $chosen);
    }

    /**
     * Get all options as key => value array from cache
     */
    public static function getAllCached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                return static::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    /**
     * Return associative array for form filling
     */
    public static function asArray(): array
    {
        return static::getAllCached();
    }

    /**
     * Clear options cache
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted()
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
