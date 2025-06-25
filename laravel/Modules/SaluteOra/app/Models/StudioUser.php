<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SaluteOra\Models\BasePivot;
use Parental\HasChildren;


/**
 * 
 *
 * @property string $id
 * @property string|null $type
 * @property string $user_id
 * @property string $studio_id
 * @property array<array-key, mixed>|null $schedule Orari del dottore in questo studio
 * @property bool $is_primary Indica se è lo studio principale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereUserId($value)
 * @mixin \Eloquent
 */
class StudioUser extends BasePivot
{
    use HasChildren;


    protected $table = 'studio_user';
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        //'doctor_id',
        'user_id',
        'studio_id',
        'schedule',
        'is_primary',
    ];

    /**
     * Gli attributi che devono essere convertiti.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'schedule' => 'array',
            'is_primary' => 'boolean',
        ]);
    }


}
