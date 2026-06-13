<?php

namespace App\Models;

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
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/gallery-placeholder.jpg');
    }
}
