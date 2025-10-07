<?php

namespace App\Models;

use App\Traits\HasUserStamp;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Model implements HasMedia
{
    use HasFactory, HasUlids, SoftDeletes, HasUserStamp, InteractsWithMedia;

    protected $fillable = [
        'nip',
        'name',
        'email',
        'phone',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'position',
        'rank',
        'department',
        'join_date',
        'employment_status',
        'education_level',
        'bio',
        'social_media',
        'is_active',
        'display_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'social_media' => 'json',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media|null $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->quality(85)
            ->fit(Fit::Contain, 150, 150)
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->format('webp')
            ->quality(90)
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->format('webp')
            ->quality(85)
            ->fit(Fit::Contain, 800, 800)
            ->nonQueued();
    }

    /**
     * Get the photo URL
     */
    public function getPhotoUrl(string $conversion = ''): ?string
    {
        $media = $this->getFirstMedia('photo');

        if (!$media) {
            return null;
        }

        return $conversion ? $media->getUrl($conversion) : $media->getUrl();
    }

    /**
     * Check if employee has photo
     */
    public function hasPhoto(): bool
    {
        return $this->hasMedia('photo');
    }

    /**
     * Get the user who created this employee
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this employee
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope active employees
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by display_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Get gender label
     */
    public function getGenderLabelAttribute(): string
    {
        return match($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => '-',
        };
    }

    /**
     * Get employment status label
     */
    public function getEmploymentStatusLabelAttribute(): string
    {
        return $this->employment_status;
    }

    /**
     * Get full display name with rank
     */
    public function getFullDisplayNameAttribute(): string
    {
        if ($this->rank) {
            return "{$this->name}, {$this->rank}";
        }
        return $this->name;
    }
}
