<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Pages;

use Filament\Forms\Get;
use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\States\User\UserState;
use Modules\Xot\Filament\Pages\XotBaseDashboard;
use Modules\Xot\Filament\Widgets\StatesChartWidget;
use Modules\Xot\Filament\Widgets\ModelTrendChartWidget;
use Modules\SaluteMo\Filament\Widgets\UserStatesChartWidget;
use Modules\SaluteMo\Filament\Widgets\DoctorStatesChartWidget;
use Modules\SaluteMo\Filament\Widgets\AppointmentStatesChartWidget;
use Modules\User\Filament\Widgets\UserTypeRegistrationsChartWidget;
use Modules\SaluteMo\Filament\Widgets\AppointmentCreationChartWidget;
use Modules\SaluteMo\Filament\Widgets\DoctorRegistrationsChartWidget;
use Modules\SaluteMo\Filament\Widgets\PatientRegistrationsChartWidget;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Dashboard amministrativa per il modulo SaluteMo.
 *
 * Entry point per widget, overview e navigazione amministrativa.
 * Titolo e descrizione sono presi dai file di traduzione.
 *
 * @package Modules\SaluteMo\Filament\Pages
 */
class Dashboard extends XotBaseDashboard
{
    

    public function getFiltersFormSchema():array{
        return [
           /*
            DatePicker::make('startDate')
                ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
            DatePicker::make('endDate')
                ->minDate(fn (Get $get) => $get('startDate') ?: now())
                ->maxDate(now()),
            */
        ];
    }

    /**
     * Widget da visualizzare nell'header della dashboard.
     *
     * @return array<class-string>
     */
    public function getHeaderWidgets(): array
    {
        return [
           
        ];
    }

    /**
     * Widget da visualizzare nel footer della dashboard.
     *
     * @return array<class-string>
     */
    public function getFooterWidgets(): array
    {
        return [
            UserTypeRegistrationsChartWidget::make(['model' => Patient::class]),
            StatesChartWidget::make(['stateClass'=>UserState::class,'model'=>Patient::class]), 

            UserTypeRegistrationsChartWidget::make(['model' => Doctor::class]),
            StatesChartWidget::make(['stateClass'=>UserState::class,'model'=>Doctor::class]), 

            UserTypeRegistrationsChartWidget::make(['model' => Admin::class]),
            StatesChartWidget::make(['stateClass'=>UserState::class,'model'=>Admin::class]), 
            
            ModelTrendChartWidget::make(['model' => Appointment::class]),
            StatesChartWidget::make(['stateClass'=>AppointmentState::class,'model'=>Appointment::class]), 
            /*
            UserTypeRegistrationsChartWidget::make(['model' => Doctor::class]),
            UserTypeRegistrationsChartWidget::make(['model' => Admin::class]),
            */
            /*
            PatientRegistrationsChartWidget::class,
            UserStatesChartWidget::class,
            DoctorRegistrationsChartWidget::class,
            DoctorStatesChartWidget::class,
            AppointmentCreationChartWidget::class,
            AppointmentStatesChartWidget::class,
            */
        ];
    }

    /**
     * Widget da visualizzare nella dashboard (metodo richiesto da Filament).
     *
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            // Widget generali della dashboard
        ];
    }
}
