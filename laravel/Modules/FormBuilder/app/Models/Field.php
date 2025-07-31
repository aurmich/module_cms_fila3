<?php

namespace Modules\FormBuilder\Models;

use LaraZeus\Bolt\Models\Field as BaseField;

/**
 * @property int $id
 * @property int|null $section_id
 * @property array<array-key, mixed> $name
 * @property string|null $description
 * @property string $type
 * @property int $ordering
 * @property array<array-key, mixed>|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FieldResponse> $fieldResponses
 * @property-read int|null $field_responses_count
 * @property-read \Modules\FormBuilder\Models\Section|null $section
 * @property-read mixed $translations
 * @method static \LaraZeus\Bolt\Database\Factories\FieldFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field withoutTrashed()
 * @mixin \Eloquent
 */
class Field extends BaseField
{
    
}