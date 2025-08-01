<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FormField> $fields
 * @property-read int|null $fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FormSubmission> $submissions
 * @property-read int|null $submissions_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormTemplate query()
 * @mixin \Eloquent
 */
class FormTemplate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'settings',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    public static function count(): int
    {
        return static::query()->count();
    }
} 