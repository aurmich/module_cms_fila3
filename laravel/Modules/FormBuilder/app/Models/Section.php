<?php

namespace Modules\FormBuilder\Models;

use LaraZeus\Bolt\Models\Section as BaseSection;

/**
 * @property int $id
 * @property int|null $form_id
 * @property int|null $field_id
 * @property int|null $response_id
 * @property string|null $response
 * @property int|null $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property array<array-key, mixed> $name
 * @property int $ordering
 * @property int $columns
 * @property string|null $description
 * @property string|null $icon
 * @property int $aside
 * @property int $compact
 * @property array<array-key, mixed>|null $options
 * @property int $borderless
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Field> $fields
 * @property-read int|null $fields_count
 * @property-read \Modules\FormBuilder\Models\Form|null $form
 * @property-read mixed $translations
 * @method static \LaraZeus\Bolt\Database\Factories\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereAside($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereBorderless($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereColumns($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCompact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section withoutTrashed()
 * @mixin \Eloquent
 */
class Section extends BaseSection
{
    
}