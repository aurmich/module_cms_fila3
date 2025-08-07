# Analisi e Miglioramenti Widget SaluteOra

## 📊 Audit Stato Attuale

### Widget Esistenti e Problemi

#### 1. ✅ DoctorCalendarWidget.php
**Status**: 🟢 **ECCELLENTE** - Pattern di riferimento
- ✅ Estende `FullCalendarWidget` (appropriato)
- ✅ `declare(strict_types=1)`
- ✅ Trait `HasFullCalendarConfig` (DRY)
- ✅ Multi-tenant con `Filament::getTenant()`
- ✅ Security con `canView()` e UserTypeEnum
- ✅ Cache intelligente
- ✅ PHPDoc completi e tipizzazione rigorosa

#### 2. ❌ StudioOverviewWidget.php 
**Status**: 🔴 **PROBLEMATICO** - Violazioni gravi
- ❌ Estende `Widget` invece di `XotBaseWidget`
- ❌ View path `saluteora::` invece del pattern standard
- ❌ Manca controllo multi-tenant
- ❌ Auth troppo generica (`can('view_any_studio')`)

#### 3. ❌ MANCANTE: DoctorAvailabilitiesWidget.php
**Status**: 🔴 **CRITICO** - Widget richiesto ma inesistente
- ❌ Homepage dottore rotta
- ❌ Functionality critica mancante

## 🎯 Piano di Miglioramento

### Fase 1: Fix StudioOverviewWidget

#### Problemi da Risolvere
1. **Violazione Pattern Laraxot**: Estende `Widget` invece di `XotBaseWidget`
2. **View Path Non-Standard**: Usa `saluteora::` invece del pattern corretto  
3. **Security Insufficiente**: Controllo accessi troppo generico
4. **Multi-Tenancy Missing**: Non considera il contesto studio

#### Fix Proposto
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget; // ✅ Fix: Estende XotBaseWidget
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;

/**
 * Widget panoramica studi per amministratori.
 * 
 * Visualizza statistiche aggregate degli studi nel sistema
 * con controlli di accesso appropriati e context multi-tenant.
 */
class StudioOverviewWidget extends XotBaseWidget
{
    protected static string $view = 'saluteora::filament.widgets.studio-overview'; // ✅ Fix: Path corretto
    protected static ?int $sort = 1;

    /**
     * Verifica se l'utente può visualizzare il widget.
     * 
     * @return bool
     */
    public static function canView(): bool
    {
        // ✅ Fix: Security specifica per UserType e multi-tenancy
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        
        // Solo admin possono vedere overview globale
        if ($user->type === UserTypeEnum::ADMIN->value) {
            return true;
        }
        
        // Dottori possono vedere stats solo del proprio studio
        if ($user->type === UserTypeEnum::DOCTOR->value && Filament::getTenant()) {
            return $user->studios()->where('id', Filament::getTenant()->id)->exists();
        }
        
        return false;
    }

    /**
     * Dati per la view.
     * 
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $user = auth()->user();
        $isGlobalAdmin = $user->type === UserTypeEnum::ADMIN->value;
        
        // ✅ Fix: Context-aware data based on user type
        if ($isGlobalAdmin) {
            return $this->getGlobalStats();
        } else {
            return $this->getStudioSpecificStats();
        }
    }
    
    /**
     * Statistiche globali per admin.
     * 
     * @return array<string, mixed>
     */
    private function getGlobalStats(): array
    {
        $stats = [
            'total' => Studio::count(),
            'active' => Studio::where('active', true)->count(),
            'inactive' => Studio::where('active', false)->count(),
            'cities' => Studio::distinct('city')->count('city'),
            'doctors' => Studio::withCount('doctors')->sum('doctors_count'),
            'appointments' => Studio::withCount(['appointments' => function ($query) {
                $query->whereMonth('start_time', now()->month)
                    ->whereYear('start_time', now()->year);
            }])->sum('appointments_count'),
        ];

        $citiesData = Studio::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->orderByDesc('total')
            ->limit(8)
            ->pluck('total', 'city')
            ->toArray();

        return [
            'stats' => $stats,
            'citiesData' => $citiesData,
            'isGlobal' => true,
        ];
    }
    
    /**
     * Statistiche specifiche per studio corrente.
     * 
     * @return array<string, mixed>
     */
    private function getStudioSpecificStats(): array
    {
        $studio = Filament::getTenant();
        
        if (!$studio) {
            return ['stats' => [], 'isGlobal' => false];
        }
        
        $stats = [
            'studio_name' => $studio->name,
            'doctors' => $studio->doctors()->count(),
            'active_doctors' => $studio->doctors()->where('active', true)->count(),
            'appointments_today' => $studio->appointments()
                ->whereDate('start_time', today())
                ->count(),
            'appointments_week' => $studio->appointments()
                ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'appointments_month' => $studio->appointments()
                ->whereMonth('start_time', now()->month)
                ->whereYear('start_time', now()->year)
                ->count(),
        ];
        
        return [
            'stats' => $stats,
            'isGlobal' => false,
        ];
    }
}
```

### Fase 2: Implementazione DoctorAvailabilitiesWidget

#### Struttura Completa
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

/**
 * Widget gestione disponibilità dottore.
 * 
 * Visualizza e permette la gestione delle disponibilità del dottore
 * per il tenant (studio) corrente utilizzando il modello Appointment
 * seguendo il pattern DRY del modulo.
 */
class DoctorAvailabilitiesWidget extends XotBaseWidget
{
    protected static string $view = 'saluteora::filament.widgets.doctor-availabilities';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    /**
     * Verifica se l'utente può visualizzare il widget.
     * 
     * @return bool
     */
    public static function canView(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        
        // Solo dottori
        if ($user->type !== UserTypeEnum::DOCTOR->value) {
            return false;
        }
        
        // Deve avere un tenant attivo
        $tenant = Filament::getTenant();
        if (!$tenant) {
            return false;
        }
        
        // Dottore deve appartenere al tenant
        return $user->studios()->where('id', $tenant->id)->exists();
    }

    /**
     * Dati per la view.
     * 
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $cacheKey = $this->getCacheKey();
        
        return cache()->remember($cacheKey, 300, function () {
            return [
                'availabilities' => $this->getCurrentAvailabilities(),
                'weeklyStats' => $this->getWeeklyStats(),
                'quickActions' => $this->getQuickActions(),
                'upcomingSlots' => $this->getUpcomingSlots(),
            ];
        });
    }

    /**
     * Recupera disponibilità correnti del dottore.
     * 
     * Utilizza il pattern DRY: disponibilità = Appointment con type=availability
     * 
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment>
     */
    private function getCurrentAvailabilities(): Collection
    {
        return Appointment::where('doctor_id', auth()->id())
            ->where('studio_id', Filament::getTenant()->id)
            ->where('type', AppointmentTypeEnum::AVAILABILITY)
            ->where('status', AppointmentStatusEnum::AVAILABLE)
            ->whereDate('start_time', '>=', today())
            ->orderBy('start_time')
            ->take(20)
            ->get();
    }

    /**
     * Statistiche settimanali delle disponibilità.
     * 
     * @return array<string, mixed>
     */
    private function getWeeklyStats(): array
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        
        $totalSlots = Appointment::where('doctor_id', auth()->id())
            ->where('studio_id', Filament::getTenant()->id)
            ->where('type', AppointmentTypeEnum::AVAILABILITY)
            ->whereBetween('start_time', [$weekStart, $weekEnd])
            ->count();
            
        $bookedSlots = Appointment::where('doctor_id', auth()->id())
            ->where('studio_id', Filament::getTenant()->id)
            ->whereIn('type', [
                AppointmentTypeEnum::CONSULTATION,
                AppointmentTypeEnum::TREATMENT,
                AppointmentTypeEnum::EMERGENCY
            ])
            ->whereBetween('start_time', [$weekStart, $weekEnd])
            ->count();
            
        $availableSlots = $totalSlots - $bookedSlots;
        $occupationRate = $totalSlots > 0 ? round(($bookedSlots / $totalSlots) * 100) : 0;
        
        return [
            'total_slots' => $totalSlots,
            'available_slots' => $availableSlots,
            'booked_slots' => $bookedSlots,
            'occupation_rate' => $occupationRate,
        ];
    }

    /**
     * Azioni rapide per il widget.
     * 
     * @return array<string, array<string, mixed>>
     */
    private function getQuickActions(): array
    {
        return [
            'add_availability' => [
                'label' => __('saluteora::doctor_availabilities.actions.add.label'),
                'icon' => 'heroicon-o-plus',
                'action' => 'openAvailabilityModal',
                'color' => 'success',
            ],
            'manage_schedule' => [
                'label' => __('saluteora::doctor_availabilities.actions.manage.label'),
                'icon' => 'heroicon-o-calendar-days',
                'url' => route('filament.pages.doctor-availability'),
                'color' => 'primary',
            ],
            'view_calendar' => [
                'label' => __('saluteora::doctor_availabilities.actions.calendar.label'),
                'icon' => 'heroicon-o-calendar',
                'action' => 'redirectToCalendar',
                'color' => 'info',
            ],
        ];
    }

    /**
     * Prossimi slot disponibili.
     * 
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment>
     */
    private function getUpcomingSlots(): Collection
    {
        return Appointment::where('doctor_id', auth()->id())
            ->where('studio_id', Filament::getTenant()->id)
            ->where('type', AppointmentTypeEnum::AVAILABILITY)
            ->where('status', AppointmentStatusEnum::AVAILABLE)
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->take(5)
            ->get();
    }

    /**
     * Genera chiave cache per il widget.
     * 
     * @return string
     */
    private function getCacheKey(): string
    {
        return sprintf(
            'doctor_availabilities_%s_%s_%s',
            auth()->id(),
            Filament::getTenant()->id,
            now()->format('Y-m-d-H')
        );
    }

    /**
     * Metodo Livewire per aprire modal di aggiunta disponibilità.
     * 
     * @return void
     */
    public function openAvailabilityModal(): void
    {
        $this->dispatch('open-availability-modal');
    }

    /**
     * Metodo Livewire per redirect al calendario.
     * 
     * @return void
     */
    public function redirectToCalendar(): void
    {
        $this->redirect(route('filament.pages.doctor-calendar'));
    }

    /**
     * Invalida la cache del widget.
     * 
     * @return void
     */
    public function invalidateCache(): void
    {
        cache()->forget($this->getCacheKey());
    }
}
```

## 🎨 View Templates Necessarie

### StudioOverviewWidget View
```blade
{{-- resources/views/filament/widgets/studio-overview.blade.php --}}
<x-filament::widget>
    <x-filament::section>
        <div class="space-y-4">
            @if($isGlobal)
                {{-- Vista amministratore globale --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-success-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-success-600">{{ __('saluteora::studio_overview.stats.total') }}</h3>
                        <p class="text-2xl font-bold text-success-800">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-primary-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-primary-600">{{ __('saluteora::studio_overview.stats.active') }}</h3>
                        <p class="text-2xl font-bold text-primary-800">{{ $stats['active'] }}</p>
                    </div>
                    <div class="bg-warning-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-warning-600">{{ __('saluteora::studio_overview.stats.doctors') }}</h3>
                        <p class="text-2xl font-bold text-warning-800">{{ $stats['doctors'] }}</p>
                    </div>
                </div>
            @else
                {{-- Vista dottore studio-specific --}}
                <div class="bg-gradient-to-r from-primary-50 to-primary-100 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-primary-800 mb-4">{{ $stats['studio_name'] }}</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-primary-600">{{ __('saluteora::studio_overview.stats.appointments_today') }}</p>
                            <p class="text-xl font-bold text-primary-800">{{ $stats['appointments_today'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-primary-600">{{ __('saluteora::studio_overview.stats.appointments_week') }}</p>
                            <p class="text-xl font-bold text-primary-800">{{ $stats['appointments_week'] }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament::widget>
```

### DoctorAvailabilitiesWidget View
```blade
{{-- resources/views/filament/widgets/doctor-availabilities.blade.php --}}
<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::doctor_availabilities.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('saluteora::doctor_availabilities.description') }}
        </x-slot>

        <div class="space-y-6">
            {{-- Stats Overview --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-success-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-success-600">{{ __('saluteora::doctor_availabilities.stats.available') }}</p>
                    <p class="text-2xl font-bold text-success-800">{{ $weeklyStats['available_slots'] }}</p>
                </div>
                <div class="bg-primary-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-primary-600">{{ __('saluteora::doctor_availabilities.stats.booked') }}</p>
                    <p class="text-2xl font-bold text-primary-800">{{ $weeklyStats['booked_slots'] }}</p>
                </div>
                <div class="bg-warning-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-warning-600">{{ __('saluteora::doctor_availabilities.stats.total') }}</p>
                    <p class="text-2xl font-bold text-warning-800">{{ $weeklyStats['total_slots'] }}</p>
                </div>
                <div class="bg-info-50 p-4 rounded-lg text-center">
                    <p class="text-sm text-info-600">{{ __('saluteora::doctor_availabilities.stats.occupation') }}</p>
                    <p class="text-2xl font-bold text-info-800">{{ $weeklyStats['occupation_rate'] }}%</p>
                </div>
            </div>

            {{-- Upcoming Slots --}}
            @if($upcomingSlots->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold mb-3">{{ __('saluteora::doctor_availabilities.upcoming.title') }}</h3>
                    <div class="space-y-2">
                        @foreach($upcomingSlots as $slot)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $slot->start_time->format('d/m/Y H:i') }}</p>
                                    <p class="text-sm text-gray-600">{{ $slot->start_time->diffForHumans() }}</p>
                                </div>
                                <div class="text-sm">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-success-100 text-success-800">
                                        {{ __('saluteora::doctor_availabilities.status.available') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quick Actions --}}
            <div class="flex flex-wrap gap-3">
                @foreach($quickActions as $actionKey => $action)
                    @if(isset($action['url']))
                        <a href="{{ $action['url'] }}" 
                           class="inline-flex items-center px-4 py-2 bg-{{ $action['color'] }}-600 text-white rounded-md hover:bg-{{ $action['color'] }}-700 transition-colors">
                            <x-heroicon-o-{{ str_replace('heroicon-o-', '', $action['icon']) }} class="w-4 h-4 mr-2"/>
                            {{ $action['label'] }}
                        </a>
                    @else
                        <button wire:click="{{ $action['action'] }}" 
                                class="inline-flex items-center px-4 py-2 bg-{{ $action['color'] }}-600 text-white rounded-md hover:bg-{{ $action['color'] }}-700 transition-colors">
                            <x-heroicon-o-{{ str_replace('heroicon-o-', '', $action['icon']) }} class="w-4 h-4 mr-2"/>
                            {{ $action['label'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
```

## 📋 Files di Traduzione Necessari

### Studio Overview
```php
// lang/it/studio_overview.php
return [
    'stats' => [
        'total' => 'Studi Totali',
        'active' => 'Studi Attivi',
        'doctors' => 'Dottori Totali',
        'appointments_today' => 'Appuntamenti Oggi',
        'appointments_week' => 'Appuntamenti Settimana',
    ],
];
```

### Doctor Availabilities
```php
// lang/it/doctor_availabilities.php
return [
    'title' => 'Le Tue Disponibilità',
    'description' => 'Gestisci i tuoi orari di disponibilità per questo studio',
    'stats' => [
        'available' => 'Slot Liberi',
        'booked' => 'Prenotati',
        'total' => 'Totale',
        'occupation' => 'Occupazione',
    ],
    'upcoming' => [
        'title' => 'Prossimi Slot Disponibili',
    ],
    'status' => [
        'available' => 'Disponibile',
    ],
    'actions' => [
        'add' => [
            'label' => 'Aggiungi Disponibilità',
        ],
        'manage' => [
            'label' => 'Gestisci Orari',
        ],
        'calendar' => [
            'label' => 'Vedi Calendario',
        ],
    ],
];
```

## 🎯 Piano di Implementazione

### Priorità 1: Critical (Immediato)
1. **Implementare DoctorAvailabilitiesWidget** (homepage dottore rotta)
2. **Fix StudioOverviewWidget** per conformità Laraxot

### Priorità 2: Important (Questa settimana)
1. **Creare view templates** responsive e accessibili
2. **Setup traduzioni** complete
3. **Testing** di regressione per widget esistenti

### Priorità 3: Enhancement (Prossima settimana)  
1. **Performance optimization** con caching avanzato
2. **Real-time updates** tra widget correlati
3. **Analytics tracking** per usage metrics

## 🔗 Collegamenti

- [BaseTransition Pattern](../models/base-transition-pattern.md)
- [Doctor Availability Management](../doctor-availability-management.md)
- [Widget Best Practices](find-doctor-appointment-widget.md)
- [Multi-Tenancy Documentation](../../Tenant/docs/README.md)

---

**Status**: 📋 Analysis Complete - Implementation Required  
**Priority**: 🔥 High (Homepage dottore rotta)  
**Timeline**: 🚀 2-3 giorni per implementation completa

*Ultimo aggiornamento: Gennaio 2025* 