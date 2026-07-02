<?php

namespace App\Support;

class ImageUrlResolver
{
    public static function toPublicUrl(?string $path, ?string $fallback = null): string
    {
        $fallback ??= '/images/default-car.png';

        if (empty($path)) {
            return $fallback;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'storage/')) {
            $normalized = substr($normalized, strlen('storage/'));
        }

        if (str_starts_with($normalized, 'public/')) {
            $normalized = substr($normalized, strlen('public/'));
        }

        if (str_starts_with($normalized, 'images/')) {
            return '/' . $normalized;
        }

        return '/images/' . $normalized;
    }
}
