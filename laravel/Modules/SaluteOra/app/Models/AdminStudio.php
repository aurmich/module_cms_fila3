<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SaluteOra\Models\User;
use Parental\HasParent;



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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereUserId($value)
 * @mixin \Eloquent
 */
class AdminStudio extends StudioUser
{
    use HasParent;
}