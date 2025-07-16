<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaGallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'order',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer'
    ];

    public function getImageUrl()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeInKb()
    {
        return round($this->file_size / 1024, 2) . ' KB';
    }
}
