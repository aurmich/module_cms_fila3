<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Modules\User\Models\BaseTenant;
use Spatie\OpeningHours\OpeningHours;
use Filament\Models\Contracts\HasName;
use Modules\SaluteOra\Models\BaseModel;
use Modules\User\Models\Traits\IsTenant;
use Modules\Xot\Models\Traits\RelationX;
use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Models\Traits\HasAddress;
use Modules\User\Contracts\TenantContract;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Studio model for the SaluteOra module.
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $slug
 * @property string|null $website
 * @property string|null $registration_number
 * @property string|null $vat_number
 * @property string|null $description
 * @property array|null $opening_hours
 * @property array|null $services
 * @property bool $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Doctor> $doctors
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Address> $addresses
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read int|null $addresses_count
 * @property-read int|null $appointments_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\StudioUser|\Modules\SaluteOra\Models\DoctorStudio|null $pivot
 * @property-read int|null $doctors_count
 * @property-read string $services_string
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio active()
 * @method static \Modules\SaluteOra\Database\Factories\StudioFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inCity(string $city)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inPostalCode(string $postalCode)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inProvince(string $province)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inRegion(string $region)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereOpeningHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereWebsite($value)
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $province
 * @property string|null $region
 * @property string $country
 * @property string|null $tax_code
 * @property string|null $settings
 * @property string|null $business_hours
 * @property string|null $model_type
 * @property string|null $model_id
 * @property-read string|null $full_address
 * @method static Builder<static>|Studio ofCap(string|int|null $cap)
 * @method static Builder<static>|Studio whereAddress($value)
 * @method static Builder<static>|Studio whereBusinessHours($value)
 * @method static Builder<static>|Studio whereCity($value)
 * @method static Builder<static>|Studio whereCountry($value)
 * @method static Builder<static>|Studio whereModelId($value)
 * @method static Builder<static>|Studio whereModelType($value)
 * @method static Builder<static>|Studio wherePostalCode($value)
 * @method static Builder<static>|Studio whereProvince($value)
 * @method static Builder<static>|Studio whereRegion($value)
 * @method static Builder<static>|Studio whereSettings($value)
 * @method static Builder<static>|Studio whereTaxCode($value)
 * @mixin \Eloquent
 */
class Studio extends BaseTenant
{
    use LogsActivity;
    use HasAddress;
    

   /** @var string */
   protected $connection = 'salute_ora';

    /** @var string */
    protected $table = 'studios';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'phone',
        'email',
        'website',
        'registration_number',
        'vat_number',
        'description',
        'opening_hours',
        'services',
        'active',
    ];

     /** @var list<string> */
     protected $with = [
        'address',
     ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'opening_hours' => 'array',
            'services' => 'array',
            'active' => 'boolean',
        ];
    }

    /*
     * Implementazione del contratto HasName per Filament tenancy.
    
    public function getFilamentName(): string
    {
        return $this->name;
    }
    */
    /**
     * Configurazione per il logging delle attività.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'phone',
                'email',
                'registration_number',
                'active'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relazione molti-a-molti con i dottori che lavorano nello studio.
     * 
     * IMPORTANTE: Questa è una relazione cross-database, dove:
     * - Doctor risiede nel database 'user'
     * - Studio risiede nel database 'salute_ora'
     * - doctor_studio (pivot) risiede nel database 'salute_ora'
     *
     * @return BelongsToMany
     */
    public function doctors(): BelongsToMany
    {
        // Per una relazione cross-database, non possiamo usare belongsToManyX
        // Dobbiamo specificare esplicitamente tutti i parametri
        return $this->belongsToManyX(Doctor::class);
    }

    /**
     * Relazione con gli appuntamenti dello studio.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'studio_id');
    }

    /**
     * Scope per studi attivi.
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('active', true);
    }

    /**
     * Verifica se lo studio è attivo.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Attiva lo studio.
     */
    public function activate(): void
    {
        $this->update(['active' => true]);
    }

    /**
     * Disattiva lo studio.
     */
    public function deactivate(): void
    {
        $this->update(['active' => false]);
    }

    /**
     * Ottiene gli orari di apertura per un giorno specifico.
     */
    public function getOpeningHoursForDay(string $day): ?array
    {
        return $this->opening_hours[$day] ?? null;
    }

    /**
     * Verifica se lo studio è aperto in un giorno specifico.
     */
    public function isOpenOnDay(string $day): bool
    {
        $hours = $this->getOpeningHoursForDay($day);
        return $hours && !empty($hours['open']) && !empty($hours['close']);
    }

    /**
     * Ottiene tutti i servizi offerti dallo studio.
     */
    public function getServices(): array
    {
        return $this->services ?? [];
    }

    /**
     * Verifica se lo studio offre un servizio specifico.
     */
    public function hasService(string $service): bool
    {
        return in_array($service, $this->getServices());
    }

    /**
     * Aggiunge un servizio allo studio.
     */
    public function addService(string $service): void
    {
        $services = $this->getServices();
        if (!in_array($service, $services)) {
            $services[] = $service;
            $this->update(['services' => $services]);
        }
    }

    /**
     * Rimuove un servizio dallo studio.
     */
    public function removeService(string $service): void
    {
        $services = $this->getServices();
        $services = array_filter($services, fn($s) => $s !== $service);
        $this->update(['services' => array_values($services)]);
    }

    /**
     * Ottiene il numero di dottori attivi nello studio.
     */
    public function getActiveDoctorsCount(): int
    {
        return $this->doctors()->where('active', true)->count();
    }

    /**
     * Ottiene il numero di appuntamenti del mese corrente.
     */
    public function getCurrentMonthAppointmentsCount(): int
    {
        return $this->appointments()
            ->whereMonth('start_time', now()->month)
            ->whereYear('start_time', now()->year)
            ->count();
    }

    /**
     * Ottiene le informazioni di contatto formattate.
     */
    public function getContactInfo(): array
    {
        return array_filter([
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
        ]);
    }

    /**
     * Restituisce i servizi come stringa leggibile per Filament.
     */
    public function getServicesStringAttribute(): string
    {
        return is_array($this->services) ? implode(', ', $this->services) : (string) $this->services;
    }


    public function scopeOfCap(Builder $query,string|int|null $cap): void
    {
        $query->whereHas('address', function($q) use ($cap) {
            $q->where('postal_code', $cap);
        });
    }

    public function getEnabledDatesByMonth(string $month): array
    {
        /*
        if($this->doctors->count()==0){
            $doctor = Doctor::inRandomOrder()->first();
            $this->doctors()->attach($doctor);
        }
        */
        $dates=[];
        $doctors=$this->doctors()->get();
        foreach($doctors as $doctor){
            //** @phpstan-ignore-next-line */
            $tmp=$this->getDoctorEnabledDatesByMonth($doctor->id, $month);
            $dates=array_merge($dates, $tmp);
            
        }
        return $dates;
        /*
        $openingHours = OpeningHours::create([
            //'monday'     => ['09:00-12:00', '13:00-18:00'],
            'monday'     => [],
            'tuesday'    => ['09:00-12:00', '13:00-18:00'],
            'wednesday'  => ['09:00-12:00'],
            'thursday'   => ['09:00-12:00', '13:00-18:00'],
            'friday'     => ['09:00-12:00', '13:00-20:00'],
            'saturday'   => ['09:00-12:00', '13:00-16:00'],
            'sunday'     => [],
            'exceptions' => [
                //'2016-11-11' => ['09:00-12:00'],
                //'2016-12-25' => [],
                '01-01'      => [],                // Recurring on each 1st of January
                '12-25'      => ['09:00-12:00'],   // Recurring on each 25th of December
            ],
        ]);

        $dates=[];
        for($i=1;$i<=31;$i++){
            $date = Carbon::parse($month.'-'.$i);
            $date1=$date->format('Y-m-d');
            if($openingHours->isOpenOn($date1)){
                $dates[] = $date1;
            }
        }
            */
        //return $dates;
       
    }


    public function getDoctorEnabledDatesByMonth(int|string|null $doctorId, string $month): array
    {
        $dates=[];
        $pivot=DoctorStudio::where('studio_id',$this->id)->where('user_id',$doctorId)->first();
        if(!$pivot){
            return [];
        }
        $openingHours=$pivot->getOpeningHours();
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
