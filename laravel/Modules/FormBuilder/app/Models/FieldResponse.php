<?php

namespace Modules\FormBuilder\Models;

use LaraZeus\Bolt\Models\FieldResponse as BaseFieldResponse;

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
 * @property-read \Modules\FormBuilder\Models\Field|null $field
 * @property-read \Modules\FormBuilder\Models\Form|null $form
 * @property-read \Modules\FormBuilder\Models\Response|null $parentResponse
 * @method static \LaraZeus\Bolt\Database\Factories\FieldResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse withoutTrashed()
 * @mixin \Eloquent
 */
class FieldResponse extends BaseFieldResponse
{
    
}