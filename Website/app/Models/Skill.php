<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Skill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'skill_category_id',
        'name',
        'slug',
        'description',
        'proficiency',
        'order',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'proficiency' => 'integer',
        'order' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            $skill->slug = $skill->slug ?? Str::slug($skill->name);
        });

        static::updating(function ($skill) {
            $skill->slug = Str::slug($skill->slug);
        });
    }

    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function getProficiencyPercentageAttribute()
    {
        return "{$this->proficiency}%";
    }
}
