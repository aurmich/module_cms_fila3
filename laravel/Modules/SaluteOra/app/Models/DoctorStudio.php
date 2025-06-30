<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Modules\SaluteOra\Models\BasePivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\OpeningHours\OpeningHours;

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
 * @property string|null $type
 * @property string $user_id
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereUserId($value)
 * @mixin \Eloquent
 */
class DoctorStudio extends StudioUser
{
    use HasParent;
     /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        //'doctor_id',
        'id',
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


    public function getOpeningHours(): OpeningHours
    {
        $schedule = $this->schedule;
        $days=[];
        foreach($schedule as $day=>$hours){
            $days[$day]=[];
            if(isset($hours['morning_from']) && isset($hours['morning_to'])){
                $days[$day][]=$hours['morning_from'].'-'.$hours['morning_to'];
            }
            if(isset($hours['afternoon_from']) && isset($hours['afternoon_to'])){
                $days[$day][]=$hours['afternoon_from'].'-'.$hours['afternoon_to'];
            }
        }
        
        return OpeningHours::create($days);
    }
}
