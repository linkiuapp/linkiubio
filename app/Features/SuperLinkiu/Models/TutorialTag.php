<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class TutorialTag extends Model
{
    protected $table = 'tutorial_tags';

    protected $fillable = [
        'name',
        'slug',
    ];

    // ==================== RELACIONES ====================

    public function tutorials(): BelongsToMany
    {
        return $this->belongsToMany(Tutorial::class, 'tutorial_tutorial_tag', 'tutorial_tag_id', 'tutorial_id');
    }

    // ==================== SCOPES ====================

    public function scopeSearch($query, ?string $search)
    {
        if (!$search) return $query;
        
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('slug', 'like', "%{$search}%");
        });
    }

    // ==================== MÉTODOS ====================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }
}
