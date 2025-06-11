<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Spatie\Activitylog\LogOptions;
use Modules\User\Models\BaseTenant;
use Filament\Models\Contracts\HasName;
use Modules\SaluteOra\Models\BaseModel;
use Modules\User\Models\Traits\IsTenant;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Geo\Models\Traits\HasAddress;
use Modules\User\Contracts\TenantContract;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modello Studio per il sistema multi-tenant.
 *
 * Rappresenta uno studio medico/dentistico che può avere
 * più dottori e gestire appuntamenti.
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string|null $registration_number
 * @property string|null $vat_number
 * @property string|null $description
 * @property array|null $opening_hours
 * @property array|null $services
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Doctor> $doctors
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Address> $addresses
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
    public function scopeActive($query)
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
}
