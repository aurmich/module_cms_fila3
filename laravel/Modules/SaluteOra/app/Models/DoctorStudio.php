<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Modules\SaluteOra\Models\BasePivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modello pivot per la relazione many-to-many tra Doctor e Studio.
 *
 * IMPORTANTE: Questa relazione attraversa database differenti:
 * - Doctor risiede nel database 'user'
 * - Studio risiede nel database 'salute_ora'
 * - DoctorStudio deve utilizzare la stessa connessione di Studio
 *
 * Estende BasePivot per garantire compatibilità con belongsToManyX e policy Xot.
 * 
 * @property int $id
 * @property string $doctor_id
 * @property string $studio_id
 * @property array|null $schedule
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\SaluteOra\Models\Doctor $doctor
 * @property-read \Modules\SaluteOra\Models\Studio $studio
 */
class DoctorStudio extends StudioUser
{
    use HasParent;
}
