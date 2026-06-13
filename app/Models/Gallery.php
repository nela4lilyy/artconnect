<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'description', 'cover_image'];

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function getCoverImageUrlAttribute(): string
    {
        if (!$this->cover_image) {
            return '';
        }
        return CloudinaryService::url($this->cover_image);
    }
}
