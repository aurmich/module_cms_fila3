<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\FormBuilder\Models\FormTemplate|null $form
 * @property-read \Modules\FormBuilder\Models\FormTemplate|null $formTemplate
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission query()
 * @mixin \Eloquent
 */
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