<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Carbon\Carbon;
use Modules\User\Models\Tenant;
use Modules\User\Models\Traits\HasTenants;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Set;
use Filament\Widgets\StatsOverview\Stat;
use Filament\Widgets\Components\StatsOverview;
use Filament\Widgets\Components\Stat as WidgetStat;

class ClinicalStatsWidget extends Widget
{
    use HasTenants;
    
    protected static ?int $sort = 2;
    
    protected static string $view = 'reporting::widgets.clinical-stats-widget';
    
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Statistiche';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = null;

    /**
     * Ottiene le statistiche cliniche per il widget.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $tenantId = Auth::user()->currentTeam?->id;
        $today = Carbon::now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        
        // Statistiche pazienti
        $totalPatients = Patient::where('tenant_id', $tenantId)->count();
        $newPatientsThisMonth = Patient::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        
        // Statistiche appuntamenti
        $totalAppointments = Appointment::where('tenant_id', $tenantId)->count();
        $pendingAppointments = Appointment::where('tenant_id', $tenantId)
            ->where('status', 'pending')
            ->count();
        $completedAppointments = Appointment::where('tenant_id', $tenantId)
            ->where('status', 'completed')
            ->count();
        
        // Appuntamenti per questo mese
        $appointmentsThisMonth = Appointment::where('tenant_id', $tenantId)
            ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
            ->count();
        
        // Statistiche ISEE
        $averageIsee = Patient::where('tenant_id', $tenantId)
            ->whereNotNull('isee_value')
            ->avg('isee_value');
        
        $patientsByIseeRange = $this->getPatientsByIseeRange($tenantId);
        
        // Geolocalizzazione pazienti
        $patientsByCity = $this->getTopPatientsByCity($tenantId);
        
        // Tasso di completamento appuntamenti
        $completionRate = $totalAppointments > 0 
            ? round(($completedAppointments / $totalAppointments) * 100, 1) 
            : 0;
        
        // Distribuzioni per mese
        $appointmentsByMonth = $this->getAppointmentsByMonth($tenantId);
        $patientsByMonth = $this->getPatientsByMonth($tenantId);
        
        return [
            'totalPatients' => $totalPatients,
            'newPatientsThisMonth' => $newPatientsThisMonth,
            'totalAppointments' => $totalAppointments,
            'pendingAppointments' => $pendingAppointments,
            'completedAppointments' => $completedAppointments,
            'appointmentsThisMonth' => $appointmentsThisMonth,
            'averageIsee' => $averageIsee,
            'patientsByIseeRange' => $patientsByIseeRange,
            'patientsByCity' => $patientsByCity,
            'completionRate' => $completionRate,
            'appointmentsByMonth' => $appointmentsByMonth,
            'patientsByMonth' => $patientsByMonth,
        ];
    }
    
    /**
     * Ottiene la distribuzione dei pazienti per fascia ISEE.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getPatientsByIseeRange(int $tenantId): array
    {
        $ranges = [
            '0-5000' => [0, 5000],
            '5001-10000' => [5001, 10000],
            '10001-15000' => [10001, 15000],
            '15001-20000' => [15001, 20000],
        ];
        
        $result = [];
        foreach ($ranges as $label => $range) {
            $result[$label] = Patient::where('tenant_id', $tenantId)
                ->whereBetween('isee_value', $range)
                ->count();
        }
        
        return $result;
    }
    
    /**
     * Ottiene le prime 5 città con più pazienti.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getTopPatientsByCity(int $tenantId): array
    {
        return Patient::where('tenant_id', $tenantId)
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->pluck('total', 'city')
            ->toArray();
    }
    
    /**
     * Ottiene la distribuzione degli appuntamenti per mese nell'anno corrente.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getAppointmentsByMonth(int $tenantId): array
    {
        $year = date('Y');
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $startDate = "{$year}-{$month}-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $count = Appointment::where('tenant_id', $tenantId)
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->count();
            
            $monthName = Carbon::createFromDate($year, $i, 1)->locale('it')->monthName;
            $months[$monthName] = $count;
        }
        
        return $months;
    }
    
    /**
     * Ottiene la distribuzione dei nuovi pazienti per mese nell'anno corrente.
     *
     * @param int $tenantId
     * @return array<string, int>
     */
    protected function getPatientsByMonth(int $tenantId): array
    {
        $year = date('Y');
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $startDate = "{$year}-{$month}-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $count = Patient::where('tenant_id', $tenantId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            
            $monthName = Carbon::createFromDate($year, $i, 1)->locale('it')->monthName;
            $months[$monthName] = $count;
        }
        
        return $months;
    }

    public static function getFormSchema(): array
    {
        return [
            Select::make('tenant_id')
                ->relationship('tenant', 'name')
                ->required()
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(fn (Set $set) => $set('doctor_id', null))
                ->label(__('saluteora::clinical_stats.fields.tenant_id.label'))
                ->placeholder(__('saluteora::clinical_stats.fields.tenant_id.placeholder'))
                ->tooltip(__('saluteora::clinical_stats.fields.tenant_id.tooltip')),
            Select::make('doctor_id')
                ->relationship('doctor', 'name')
                ->required()
                ->searchable()
                ->preload()
                ->live()
                ->label(__('saluteora::clinical_stats.fields.doctor_id.label'))
                ->placeholder(__('saluteora::clinical_stats.fields.doctor_id.placeholder'))
                ->tooltip(__('saluteora::clinical_stats.fields.doctor_id.tooltip')),
            DatePicker::make('start_date')
                ->required()
                ->live()
                ->label(__('saluteora::clinical_stats.fields.start_date.label'))
                ->placeholder(__('saluteora::clinical_stats.fields.start_date.placeholder'))
                ->tooltip(__('saluteora::clinical_stats.fields.start_date.tooltip')),
            DatePicker::make('end_date')
                ->required()
                ->live()
                ->label(__('saluteora::clinical_stats.fields.end_date.label'))
                ->placeholder(__('saluteora::clinical_stats.fields.end_date.placeholder'))
                ->tooltip(__('saluteora::clinical_stats.fields.end_date.tooltip')),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('saluteora::clinical_stats.navigation.label');
    }

    protected function getStats(): array
    {
        $tenantId = $this->tenant_id;
        $doctorId = $this->doctor_id;
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        $query = Appointment::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->when($doctorId, fn ($q) => $q->where('doctor_id', $doctorId))
            ->when($startDate, fn ($q) => $q->where('start_time', '>=', $startDate))
            ->when($endDate, fn ($q) => $q->where('end_time', '<=', $endDate));

        $totalAppointments = $query->count();
        $completedAppointments = (clone $query)->where('status', 'completed')->count();
        $cancelledAppointments = (clone $query)->where('status', 'cancelled')->count();
        $noShowAppointments = (clone $query)->where('status', 'no_show')->count();

        $completionRate = $totalAppointments > 0 ? round(($completedAppointments / $totalAppointments) * 100, 2) : 0;
        $cancellationRate = $totalAppointments > 0 ? round(($cancelledAppointments / $totalAppointments) * 100, 2) : 0;
        $noShowRate = $totalAppointments > 0 ? round(($noShowAppointments / $totalAppointments) * 100, 2) : 0;

        return [
            Stat::make(__('saluteora::clinical_stats.stats.total_appointments'), $totalAppointments)
                ->description(__('saluteora::clinical_stats.stats.total_appointments'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),
            Stat::make(__('saluteora::clinical_stats.stats.completed_appointments'), $completedAppointments)
                ->description(__('saluteora::clinical_stats.stats.completed_appointments'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make(__('saluteora::clinical_stats.stats.cancelled_appointments'), $cancelledAppointments)
                ->description(__('saluteora::clinical_stats.stats.cancelled_appointments'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
            Stat::make(__('saluteora::clinical_stats.stats.no_show_appointments'), $noShowAppointments)
                ->description(__('saluteora::clinical_stats.stats.no_show_appointments'))
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('warning'),
            Stat::make(__('saluteora::clinical_stats.stats.completion_rate'), $completionRate . '%')
                ->description(__('saluteora::clinical_stats.stats.completion_rate'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
            Stat::make(__('saluteora::clinical_stats.stats.cancellation_rate'), $cancellationRate . '%')
                ->description(__('saluteora::clinical_stats.stats.cancellation_rate'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('danger'),
            Stat::make(__('saluteora::clinical_stats.stats.no_show_rate'), $noShowRate . '%')
                ->description(__('saluteora::clinical_stats.stats.no_show_rate'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),
        ];
    }
}
