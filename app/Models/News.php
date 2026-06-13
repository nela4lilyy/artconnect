<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug',
        'content', 'image', 'publish_date',
    ];

    protected $casts = [
        'publish_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function generateSlug(string $title): string
    {
        $slug  = Str::slug($title);
        $count = static::where('slug', 'like', $slug . '%')->count();
        return $count ? $slug . '-' . ($count + 1) : $slug;
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return '';
        }
        return CloudinaryService::url($this->image);
    }
}
