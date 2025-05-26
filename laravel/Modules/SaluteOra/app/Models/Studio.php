<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Modello Studio per il sistema multi-tenant.
 *
 * Rappresenta uno studio medico/dentistico che può avere
 * più dottori e gestire appuntamenti.
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $postal_code
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
 */
class Studio extends Model implements HasName
{
    use SoftDeletes;
    use LogsActivity;

    /** @var string */
    protected $connection = 'mysql';

    /** @var string */
    protected $table = 'studios';

    /** @var array<string> */
    protected $fillable = [
        'name',
        'address',
        'city',
        'postal_code',
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

    /**
     * Implementazione del contratto HasName per Filament tenancy.
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * Configurazione per il logging delle attività.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'address',
                'city',
                'phone',
                'email',
                'registration_number',
                'active'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relazione con i dottori dello studio.
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'tenant_id');
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
     * Scope per studi in una specifica città.
     */
    public function scopeInCity($query, string $city)
    {
        return $query->where('city', $city);
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
     * Ottiene l'indirizzo completo formattato.
     */
    public function getFullAddress(): string
    {
        $parts = array_filter([
            $this->address,
            $this->postal_code,
            $this->city,
        ]);

        return implode(', ', $parts);
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
}
