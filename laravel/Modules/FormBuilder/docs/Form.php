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
 * @mixin \Eloquent
 */
class Form extends BaseForm
{
    
}