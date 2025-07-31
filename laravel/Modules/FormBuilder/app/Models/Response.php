<?php

namespace Modules\FormBuilder\Models;

use LaraZeus\Bolt\Models\Response as BaseResponse;

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
 * @property string|null $user_id
 * @property string|null $status
 * @property string|null $notes
 * @property int|null $extension_item_id
 * @property int|null $grades
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FieldResponse> $fieldsResponses
 * @property-read int|null $fields_responses_count
 * @property-read \Modules\FormBuilder\Models\Form|null $form
 * @property-read string $last_updated
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \LaraZeus\Bolt\Database\Factories\ResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereExtensionItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereGrades($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response withoutTrashed()
 * @mixin \Eloquent
 */
class Response extends BaseResponse
{
    
}