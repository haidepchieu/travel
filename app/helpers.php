<?php

use App\Models\Option;

if (!function_exists('option')) {
    /**
     * Get site option value by key
     */
    function option(string $key, $default = null)
    {
        return Option::get($key, $default);
    }
}

if (!function_exists('option_image')) {
    /**
     * Get site option image URL by key
     */
    function option_image(string $key, ?string $default = null): ?string
    {
        return Option::getImageUrl($key, $default);
    }
}

if (!function_exists('option_json')) {
    /**
     * Get site option JSON decoded array by key
     */
    function option_json(string $key, array $default = []): array
    {
        return Option::getJson($key, $default);
    }
}
