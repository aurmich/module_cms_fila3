<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use DateTime;
use Carbon\Carbon;
use Parental\HasParent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\OpeningHours\OpeningHours;
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


        $days['exceptions'] = [
                //'2016-11-11' => ['09:00-12:00'],
                //'2016-12-25' => [],
                '01-01'      => [],                // Recurring on each 1st of January
                '12-25'      => ['09:00-12:00'],   // Recurring on each 25th of December
        ];
        
        return OpeningHours::create($days);
    }


    /**
     * Get available time slots for a specific date.
     * 
     * @param string $date The date in Y-m-d format
     * @return array Array of time slot objects with id, label, value, and time properties
     */
    public function getAvailableTimeSlotsByDate(?string $date): Collection
    {
        if (!$date) {
            return collect([]);
        }

        $dateTime = new DateTime($date);
        
        // Ottieni gli orari di apertura tramite getOpeningHours()
        $openingHours = $this->getOpeningHours();
        
        // Verifica se è aperto nel giorno della settimana
        if (!$openingHours->isOpenOn($date)) {
            return collect([]);
        }
        
        // Ottieni gli orari di apertura per il giorno della settimana
        $openingHoursForDay = $openingHours->forDate($dateTime);
        $slots = collect();
        foreach ($openingHoursForDay as $timeRange) {
            $start = Carbon::createFromFormat('H:i', $timeRange->start()->format());
            $end = Carbon::createFromFormat('H:i', $timeRange->end()->format());
            
            // Genera slot di 60 minuti dall'inizio alla fine
            $current = $start->copy();
            while ($current->lt($end)) {
                $time = $current->format('H:i');
                $slots->push(collect(
                    (object)['id' => $time,
                    'label' => $time,
                
                ]));
                $current->addHour();
            }
        }
        return $slots;
        
        
            
      
    }
    
    /**
     * Genera slot di tempo per un range specifico
     *
     * @param string $startTime Orario di inizio (es: "08:00")
     * @param string $endTime Orario di fine (es: "10:00") 
     * @param int $slotDurationMinutes Durata slot in minuti
     * @return array Array di oggetti slot
     */
    private function generateSlotsForRange(string $startTime, string $endTime, int $slotDurationMinutes): array
    {
        $slots = [];
        
        try {
            $start = Carbon::createFromFormat('H:i', $startTime);
            $end = Carbon::createFromFormat('H:i', $endTime);
            
            $currentTime = $start->copy();
            
            // Genera slot fino all'orario di fine (escluso)
            while ($currentTime->lt($end)) {
                $slotTime = $currentTime->format('H:i');
                
                // Crea oggetto slot per RadioCollection
                $slots[] = (object) [
                    'id' => $slotTime,
                    'label' => $slotTime,
                    'value' => $slotTime,
                    'time' => $slotTime
                ];
                
                // Avanza di slot duration
                $currentTime->addMinutes($slotDurationMinutes);
            }
            
        } catch (\Exception $e) {
            Log::error('Errore nella generazione slot per range', [
                'start_time' => $startTime,
                'end_time' => $endTime,
                'error' => $e->getMessage()
            ]);
        }
        
        return $slots;
    }


    public function getEnabledDatesByMonth(string $month): array
    {
        $dates=[];
        $openingHours=$this->getOpeningHours();
        for($i=1;$i<=31;$i++){
            $date = Carbon::parse($month.'-'.$i);
            $date1=$date->format('Y-m-d');
            if($openingHours->isOpenOn($date1)){
                $dates[] = $date1;
            }
        }
        return $dates;
    }
}

