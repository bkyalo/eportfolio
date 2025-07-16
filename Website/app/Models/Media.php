<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'mime_type',
        'size',
        'dimensions',
        'duration',
        'thumbnail_path',
        'is_visible',
        'is_featured',
        'order_column',
        'custom_properties'
    ];

    protected $casts = [
        'dimensions' => 'array',
        'custom_properties' => 'array',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'size' => 'integer',
        'order_column' => 'integer',
    ];

    protected $appends = ['url', 'thumbnail_url'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'video/mp4',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-ms-wmv',
            ]);
    }

    public function registerMediaConversions(BaseMedia $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600);
    }

    public function getUrlAttribute()
    {
        return $this->getFullUrl();
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->getFullUrl('thumb');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }
}
