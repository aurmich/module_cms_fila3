<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use LaraZeus\Bolt\Models\Form as BaseForm;

/**
 * Form model for the FormBuilder module.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property array|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @property int|null $form_id
 * @property int|null $field_id
 * @property int|null $response_id
 * @property string|null $response
 * @property int|null $grade
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property int|null $user_id
 * @property int|null $category_id
 * @property int $ordering
 * @property array<array-key, mixed>|null $details
 * @property string|null $start_at
 * @property string|null $end_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property-read \Modules\FormBuilder\Models\Category|null $category
 * @property-read mixed $date_available
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Field> $fields
 * @property-read int|null $fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FieldResponse> $fieldsResponses
 * @property-read int|null $fields_responses_count
 * @property-read string $is_active_desc
 * @property-read string $last_updated
 * @property-read mixed $need_login
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Response> $responses
 * @property-read int|null $responses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Section> $sections
 * @property-read int|null $sections_count
 * @property-read mixed $slug_url
 * @property-read mixed $translations
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \LaraZeus\Bolt\Database\Factories\FormFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form withoutTrashed()
 * @mixin \Eloquent
 */
class Form extends BaseForm
{
    // Implementazione minima che estende BaseForm
    // Mantiene la documentazione PHPDoc per IDE support
}
