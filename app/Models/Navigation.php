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
        'folder_id',
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

    public function folder()
    {
        return $this->belongsTo(\TomatoPHP\FilamentMediaManager\Models\Folder::class);
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

        // If type is folder, generate gallery URL
        if ($this->type === 'folder' && $this->folder) {
            return route('gallery.folder', ['folder' => $this->folder_id]);
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
}
