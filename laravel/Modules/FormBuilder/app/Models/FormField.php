<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read \Modules\FormBuilder\Models\FormTemplate|null $formTemplate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormField query()
 * @mixin \Eloquent
 */
class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_template_id',
        'name',
        'label',
        'type',
        'required',
        'options',
        'validation_rules',
        'order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'required' => 'boolean',
            'options' => 'array',
            'validation_rules' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function formTemplate(): BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public static function where(string $column, string $operator, mixed $value): \Illuminate\Database\Eloquent\Builder
    {
        return static::query()->where($column, $operator, $value);
    }
} 