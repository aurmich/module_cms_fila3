<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;


use Carbon\Carbon;
use Safe\DateTime;
use Parental\HasParent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\OpeningHours\OpeningHours;
use Modules\SaluteOra\Models\BasePivot;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointments
 * @property-read int|null $appointments_count
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


    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class,'studio_id','studio_id')->where('doctor_id','=',$this->user_id);
    }


    public function getOpeningHours(string $month): OpeningHours
    {
        $schedule = $this->schedule;
        if(!$schedule){
            return OpeningHours::create([]);
        }
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
                //'2025-08-09' => ['09:00-10:00'], // Chiuso dalle 8:00 alle 9:00
                '01-01'      => [],                // Recurring on each 1st of January
                '12-25'      => [],   // Recurring on each 25th of December
        ];

        $days=$this->subAppointments($days,$month);
        
        /** @phpstan-ignore argument.type */
        $res= OpeningHours::create($days);
        

        return $res;
    }


    public function subAppointments(array $baseOpeningHours,string $month):array{

        /** @phpstan-ignore-next-line */
        $appointments=$this->appointments()
            ->ofYearMonth($month)
            ->get();
        
        foreach($appointments as $appointment){
            //$date=$appointment->starts_at->format('Y-m-d');
            //$days[$date][]=$appointment->starts_at->format('H:i').'-'.$appointment->ends_at->format('H:i');
            $date = $appointment->starts_at->format('Y-m-d');
            $closedFrom = $appointment->starts_at->format('H:i');
            $closedTo   = $appointment->ends_at->format('H:i');
    
            // Ricava il giorno della settimana
            $weekday = strtolower($appointment->starts_at->format('l'));
    
            // Prendi gli orari base di quel giorno
            /** @phpstan-ignore-next-line */
            $default = collect($baseOpeningHours[$weekday] ?? []);
    
            // Spezza le fasce eliminando l'intervallo di chiusura
            $updatedDaySchedule = $default->flatMap(function ($range) use ($closedFrom, $closedTo) {
                [$from, $to] = explode('-', $range);
    
                // Caso 1: la chiusura è completamente fuori dalla fascia → non toccare
                if ($closedTo <= $from || $closedFrom >= $to) {
                    return [$range];
                }
    
                // Caso 2: la chiusura copre tutta la fascia → rimuovi completamente
                if ($closedFrom <= $from && $closedTo >= $to) {
                    return [];
                }
    
                $segments = [];
    
                // Caso 3: la chiusura è interna → spezza in due segmenti
                if ($closedFrom > $from) {
                    $segments[] = "{$from}-{$closedFrom}";
                }
    
                if ($closedTo < $to) {
                    $segments[] = "{$closedTo}-{$to}";
                }
    
                return $segments;
            })->values()->all();
            $baseOpeningHours['exceptions'][$date]=$updatedDaySchedule;
        }
        return $baseOpeningHours;
    }


    /**
     * Get available time slots for a specific date.
     * 
     * @param string $date The date in Y-m-d format
     */
    public function getAvailableTimeSlotsByDate(?string $date): Collection
    {
        if (!$date) {
            return collect([]);
        }

        $dateTime = new DateTime($date);
        
        // Ottieni gli orari di apertura tramite getOpeningHours()
        $month = Carbon::createFromFormat('Y-m-d', $date)?->format('Y-m');
        if($month==null){
            throw new \Exception('Invalid date format ['.$date.']');
        }
        
        $openingHours = $this->getOpeningHours($month);
        
        // Verifica se è aperto nel giorno della settimana
        if (!$openingHours->isOpenOn($date)) {
            return collect([]);
        }
        
        // Ottieni gli orari di apertura per il giorno della settimana
        $openingHoursForDay = $openingHours->forDate($dateTime);
        $slots = collect();
        foreach ($openingHoursForDay as $timeRange) {
            /** @phpstan-ignore method.nonObject */
            $start = Carbon::createFromFormat('H:i', $timeRange->start()->format());
            /** @phpstan-ignore method.nonObject */
            $end = Carbon::createFromFormat('H:i', $timeRange->end()->format());
            if($start==null || $end==null){
                continue;
            }
            // Genera slot di 60 minuti dall'inizio alla fine
            /** @phpstan-ignore-next-line */
            $current = $start->copy();
            while ($current->lt($end)) {
                $time = $current->format('H:i');
                $slotData = [
                    'id' => $time,
                    'label' => $time,
                    'value' => $time
                ];
                $slots->push(collect($slotData));
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
    /**
     * Generate time slots for a specific time range.
     *
     * @param string $startTime Start time in H:i format
     * @param string $endTime End time in H:i format
     * @param int $slotDurationMinutes Duration of each slot in minutes
     * @return array<array{id: string, label: string, value: string}>
     */
    private function generateSlotsForRange(string $startTime, string $endTime, int $slotDurationMinutes): array
    {
        $slots = [];
        
        $start = Carbon::createFromFormat('H:i', $startTime);
        $end = Carbon::createFromFormat('H:i', $endTime);
        
        if ($start === null || $end === null) {
            return [];
        }
        
        $currentTime = $start->copy();
        
        // Generate slots until end time (exclusive)
        while ($currentTime->lt($end)) {
            $slotTime = $currentTime->format('H:i');
            
            // Create slot array for RadioCollection
            $slots[] = [
                'id' => $slotTime,
                'label' => $slotTime,
                'value' => $slotTime
            ];
                
                // Avanza di slot duration
                $currentTime->addMinutes($slotDurationMinutes);
            }
            
        
        
        return $slots;
    }


    public function getEnabledDatesByMonth(string $month): array
    {
        $start=1;
        $dates=[];
        $currentYearMonth = Carbon::now()->format('Y-m');
        if($month<$currentYearMonth){
            return [];
        }
        if($month==$currentYearMonth){
            $start=Carbon::now()->day+1;
        }
        $openingHours=$this->getOpeningHours($month);
        

        for($i=$start;$i<=31;$i++){
            $date = Carbon::parse($month.'-'.$i);
            $date1=$date->format('Y-m-d');
            if($openingHours->isOpenOn($date1)){
                $dates[] = $date1;
            }
        }
        return $dates;
    }
}

