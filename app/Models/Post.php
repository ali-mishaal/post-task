<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'body'
    ];

    protected $appends = [
        'image_url'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this?->getFirstMedia('image')?->getUrl() ?? ''
        );
    }
}
