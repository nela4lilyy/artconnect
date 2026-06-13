<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'cover_image'];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function getCoverImageUrlAttribute(): string
    {
        if (!$this->cover_image) {
            return '';
        }
        return CloudinaryService::url($this->cover_image);
    }
}
