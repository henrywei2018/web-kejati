<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'label',
        'type',
        'url',
        'page_id',
        'icon',
        'target',
        'order',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Navigation::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Navigation::class, 'parent_id')->ordered();
    }

    public function activeChildren()
    {
        return $this->hasMany(Navigation::class, 'parent_id')->active()->ordered();
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
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

    // Accessor untuk computed URL
    public function getComputedUrlAttribute(): string
    {
        // If type is page, get URL from Page model
        if ($this->type === 'page' && $this->page) {
            return $this->page->url;
        }

        // Return custom URL
        return $this->attributes['url'] ?? '#';
    }

    // Accessor untuk computed label
    public function getComputedLabelAttribute(): string
    {
        // If type is page, get label from Page model
        if ($this->type === 'page' && $this->page) {
            return $this->page->title;
        }

        return $this->label;
    }

    // Get URL path without domain (for routing)
    public function getUrlPathAttribute(): string
    {
        $url = $this->computed_url;

        // If URL is # (parent menu), generate slug from label
        if ($url === '#') {
            return \Illuminate\Support\Str::slug($this->label);
        }

        $path = parse_url($url, PHP_URL_PATH);
        return trim($path ?? '', '/');
    }
}
