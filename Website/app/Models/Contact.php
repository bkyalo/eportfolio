<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email_personal',
        'email_work',
        'phone_personal',
        'phone_work',
        'github_username',
        'x_username',
        'facebook_url',
        'linkedin_url',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'notes',
        'is_favorite',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_favorite' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's primary email (work email if available, otherwise personal).
     */
    public function getPrimaryEmailAttribute(): ?string
    {
        return $this->email_work ?? $this->email_personal;
    }

    /**
     * Get the user's primary phone (work phone if available, otherwise personal).
     */
    public function getPrimaryPhoneAttribute(): ?string
    {
        return $this->phone_work ?? $this->phone_personal;
    }

    /**
     * Get the full address as a single string.
     */
    public function getFullAddressAttribute(): string
    {
        $address = [];
        if ($this->address_line1) $address[] = $this->address_line1;
        if ($this->address_line2) $address[] = $this->address_line2;
        if ($this->city) $address[] = $this->city;
        if ($this->state) $address[] = $this->state;
        if ($this->postal_code) $address[] = $this->postal_code;
        if ($this->country) $address[] = $this->country;
        
        return implode(', ', $address);
    }

    /**
     * Scope a query to only include favorite contacts.
     */
    public function scopeFavorite($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Scope a query to search for contacts by name, email, or phone.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email_personal', 'like', "%{$search}%")
              ->orWhere('email_work', 'like', "%{$search}%")
              ->orWhere('phone_personal', 'like', "%{$search}%")
              ->orWhere('phone_work', 'like', "%{$search}%");
        });
    }
}
