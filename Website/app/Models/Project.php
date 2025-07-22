<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'image_path',
        'stack',
        'brief_description',
        'is_live',
        'github_url',
        'live_url',
        'status',
        'is_small_project',
        'is_public',
        'likes',
    ];

    protected $casts = [
        'is_live' => 'boolean',
        'is_small_project' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Increment the likes count for the project.
     *
     * @return int
     */
    public function incrementLikes()
    {
        return $this->increment('likes');
    }
}
