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
        'tags',
        'description',
        'content',
        'resource_link',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'skill_id');
    }
}

