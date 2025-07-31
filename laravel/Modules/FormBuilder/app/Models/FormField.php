<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
        'is_active' => 'boolean',
    ];

    public function formTemplate(): BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public static function where(string $column, string $operator, mixed $value): \Illuminate\Database\Eloquent\Builder
    {
        return static::query()->where($column, $operator, $value);
    }
} 