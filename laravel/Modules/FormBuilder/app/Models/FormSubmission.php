<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormSubmission extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'form_template_id',
        'data',
        'ip_address',
        'user_agent',
        'submitted_at',
    ];

    protected $casts = [
        'data' => 'array',
        'submitted_at' => 'datetime',
    ];

    /** @var array<string, mixed> */
    public array $data = [];

    public function formTemplate(): BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }

    /**
     * Alias for formTemplate relation
     */
    public function form(): BelongsTo
    {
        return $this->formTemplate();
    }

    public static function whereDate(string $column, string $operator, \DateTimeInterface|string|null $value): \Illuminate\Database\Eloquent\Builder
    {
        return static::query()->whereDate($column, $operator, $value);
    }

    /** @phpstan-ignore-next-line */
    public static function query(): \Illuminate\Database\Eloquent\Builder
    {
        /** @phpstan-ignore-next-line */
        return parent::query();
    }
} 