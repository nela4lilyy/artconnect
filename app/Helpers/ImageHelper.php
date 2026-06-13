<?php

use App\Services\CloudinaryService;

if (!function_exists('img_url')) {
    /**
     * Mengembalikan URL gambar yang benar.
     * Mendukung path Cloudinary (cloudinary::xxx) dan path lokal (storage/xxx).
     * Jika path kosong, kembalikan string kosong.
     */
    function img_url(?string $path, array $transforms = []): string
    {
        if (empty($path)) {
            return '';
        }
        return CloudinaryService::url($path, $transforms);
    }
}
