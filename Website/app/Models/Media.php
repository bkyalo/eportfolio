<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $table = 'media';
    
    protected $guarded = [];
    
    protected $attributes = [
        'manipulations' => '[]',
        'custom_properties' => '[]',
        'generated_conversions' => '[]',
        'responsive_images' => '[]',
        'dimensions' => '[]',
        'is_visible' => true,
        'is_featured' => false,
        'size' => 0,
        'order_column' => 0,
    ];
    
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
        'custom_properties',
        'name',
        'file_name',
        'disk',
        'conversions_disk',
        'collection_name',
        'uuid',
        'model_type',
        'model_id'
    ];
    
    protected $casts = [
        'custom_properties' => 'array',
        'manipulations' => 'array',
        'generated_conversions' => 'array',
        'responsive_images' => 'array',
        'dimensions' => 'array',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'size' => 'integer',
        'order_column' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    protected $appends = ['url', 'thumbnail_url'];

    /**
     * Register the media collections.
     */
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
