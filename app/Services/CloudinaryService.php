<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class CloudinaryService
{
    private string $cloudName;
    private string $apiKey;
    private string $apiSecret;
    private string $uploadUrl;

    public function __construct()
    {
        $this->cloudName = config('cloudinary.cloud_name');
        $this->apiKey    = config('cloudinary.api_key');
        $this->apiSecret = config('cloudinary.api_secret');
        $this->uploadUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";
    }

    /**
     * Upload gambar ke Cloudinary.
     * Mengembalikan "cloudinary::{public_id}" untuk disimpan di database.
     */
    public function upload(UploadedFile $file, string $folder = 'artconnect'): string
    {
        $timestamp    = time();
        $paramsToSign = "folder={$folder}&timestamp={$timestamp}{$this->apiSecret}";
        $signature    = sha1($paramsToSign);

        $response = Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post($this->uploadUrl, [
            'api_key'   => $this->apiKey,
            'timestamp' => $timestamp,
            'folder'    => $folder,
            'signature' => $signature,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Cloudinary upload gagal: ' . $response->body());
        }

        $publicId = $response->json('public_id');

        return 'cloudinary::' . $publicId;
    }

    /**
     * Hapus gambar dari Cloudinary berdasarkan path yang tersimpan.
     */
    public function delete(string $path): void
    {
        if (!str_starts_with($path, 'cloudinary::')) {
            return;
        }

        $publicId  = substr($path, strlen('cloudinary::'));
        $timestamp = time();
        $signature = sha1("public_id={$publicId}&timestamp={$timestamp}{$this->apiSecret}");

        Http::post("https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy", [
            'public_id' => $publicId,
            'api_key'   => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);
    }

    /**
     * Ubah path tersimpan menjadi URL publik yang bisa ditampilkan.
     * Mendukung path lama (storage lokal) maupun path Cloudinary.
     */
    public static function url(?string $path, array $transforms = []): string
    {
        if (empty($path)) {
            return '';
        }

        if (!str_starts_with($path, 'cloudinary::')) {
            // Path lama dari storage lokal
            return asset('storage/' . $path);
        }

        $publicId  = substr($path, strlen('cloudinary::'));
        $cloudName = config('cloudinary.cloud_name');

        $transformStr = '';
        if (!empty($transforms)) {
            $parts = [];
            foreach ($transforms as $k => $v) {
                $parts[] = "{$k}_{$v}";
            }
            $transformStr = implode(',', $parts) . '/';
        }

        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$transformStr}{$publicId}";
    }
}
