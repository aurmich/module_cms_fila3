<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SaluteOra\Models\User;
use Parental\HasParent;



/**
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereUserId($value)
 * @property-read \Modules\SaluteOra\Models\Studio|null $studio
 * @property-read User|null $user
 * @mixin IdeHelperPatientStudio
 * @mixin \Eloquent
 */
class PatientStudio extends StudioUser
{
    use HasParent;
}
