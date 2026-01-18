<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tutorial extends Model
{
    protected $table = 'tutorials';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'difficulty_level',
        'featured_image',
        'portada_image',
        'video_url',
        'order',
        'is_active',
        'views_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'views_count' => 'integer',
    ];

    // ==================== RELACIONES ====================

    public function category(): BelongsTo
    {
        return $this->belongsTo(TutorialCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(TutorialTag::class, 'tutorial_tutorial_tag', 'tutorial_id', 'tutorial_tag_id');
    }

    // ==================== ACCESSORS ====================

    public function getDifficultyLabelAttribute(): string
    {
        return match($this->difficulty_level) {
            'beginner' => 'Principiante',
            'intermediate' => 'Intermedio',
            'advanced' => 'Avanzado',
            default => $this->difficulty_level ?? 'N/A',
        };
    }

    public function getDifficultyColorAttribute(): string
    {
        return match($this->difficulty_level) {
            'beginner' => 'green',
            'intermediate' => 'yellow',
            'advanced' => 'red',
            default => 'gray',
        };
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhereHas('tags', function ($tagQuery) use ($search) {
                  $tagQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    // ==================== MÉTODOS ====================

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tutorial) {
            if (empty($tutorial->slug)) {
                $tutorial->slug = Str::slug($tutorial->title);
            }
        });

        static::updating(function ($tutorial) {
            if ($tutorial->isDirty('title') && empty($tutorial->slug)) {
                $tutorial->slug = Str::slug($tutorial->title);
            }
        });
    }
}
