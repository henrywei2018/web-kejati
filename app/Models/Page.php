<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Page extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'parent_id',
        'navigation_id',
        'slug',
        'title',
        'content',
        'type',
        'is_active',
        'order',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile();

        $this->addMediaCollection('header_image')
            ->singleFile();

        $this->addMediaCollection('header_icon')
            ->singleFile()
            ->acceptsMimeTypes(['image/svg+xml']);

        $this->addMediaCollection('gallery');
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->ordered();
    }

    public function activeChildren()
    {
        return $this->hasMany(Page::class, 'parent_id')->active()->ordered();
    }

    public function navigation()
    {
        return $this->belongsTo(\App\Models\Navigation::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // Helper Methods
    public function getFullSlugAttribute(): string
    {
        // Priority: navigation > parent > self
        if ($this->navigation) {
            // Use navigation's url_path which handles # URLs by generating slug from label
            $navPath = $this->navigation->url_path;
            return $navPath ? $navPath . '/' . $this->slug : $this->slug;
        }

        if ($this->parent) {
            return $this->parent->slug . '/' . $this->slug;
        }

        return $this->slug;
    }

    public function getUrlAttribute(): string
    {
        return url($this->full_slug);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Media Helper Methods
    public function getHeaderImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('header_image') ?: null;
    }

    public function getHeaderIconUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('header_icon') ?: null;
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('featured_image') ?: null;
    }
}
