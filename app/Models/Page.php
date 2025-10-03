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
        if ($this->parent) {
            return $this->parent->slug . '/' . $this->slug;
        }
        return $this->slug;
    }

    public function getUrlAttribute(): string
    {
        if ($this->parent) {
            return url($this->parent->slug . '/' . $this->slug);
        }
        return url($this->slug);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
