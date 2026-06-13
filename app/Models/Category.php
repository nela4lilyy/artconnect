<?php

namespace App\Models;

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
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : '';
    }
}
