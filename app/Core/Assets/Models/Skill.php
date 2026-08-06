<?php

declare(strict_types=1);

namespace App\Core\Assets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    protected $fillable = [
        'title',
        'slug',
        'tags',
        'description',
        'content',
        'resource_link',
        'resource_links',
        'is_active',
        'editor_id',
        'locked_by_admin',
        'admin_comment',
    ];

    protected $casts = [
        'tags' => 'array',
        'resource_links' => 'array',
        'is_active' => 'boolean',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'skill_id');
    }
}

