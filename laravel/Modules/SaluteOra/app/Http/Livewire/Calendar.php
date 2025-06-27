<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;

class Calendar extends Component
{
    public array $config = [];
    public array $events = [];
    public array $filters = [
        'status' => null,
        'type' => null,
        'doctor_id' => null,
        'studio_id' => null,
    ];
    public array $availableSlots = [];
    public ?string $selectedDate = null;
    public bool $showSlotModal = false;

    protected $listeners = [
        'refreshCalendar' => '$refresh',
        'eventClick',
        'select',
    ];

    public function mount(): void
    {
        $this->selectedDate = now()->toDateString();
        $this->loadConfig();
        $this->fetchEvents();
    }

    protected function loadConfig(): void
    {
        try {
            $response = Http::get(route('saluteora.calendar.config'));
            if ($response->successful()) {
                $this->config = $response->json();
            }
        } catch (\Exception $e) {
            $this->addError('config', __('Failed to load calendar configuration'));
        }
    }

    public function nextMonth(): void
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)
            ->addMonth()
            ->toDateString();
        $this->fetchEvents();
    }

    public function previousMonth(): void
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)
            ->subMonth()
            ->toDateString();
        $this->fetchEvents();
    }

    public function fetchEvents(): void
    {
        try {
            $start = now()->startOfMonth()->startOfDay()->toIso8601String();
            $end = now()->addMonths(3)->endOfMonth()->endOfDay()->toIso8601String();

            $response = Http::get(route('saluteora.calendar.events'), [
                'start' => $start,
                'end' => $end,
                'filters' => array_filter($this->filters),
            ]);

            if ($response->successful()) {
                $this->events = $response->json();
            }
        } catch (\Exception $e) {
            $this->addError('events', __('Failed to load calendar events'));
        }
    }

    public function updatedFilters()
    {
        $this->fetchEvents();
    }

    public function loadAvailableSlots($date)
    {
        try {
            $this->selectedDate = $date;
            $response = Http::get(route('saluteora.calendar.available-slots'), [
                'date' => $date,
                'duration' => 30, // Default duration in minutes
            ]);

            if ($response->successful()) {
                $this->availableSlots = $response->json();
                $this->showSlotModal = true;
            }
        } catch (\Exception $e) {
            $this->addError('slots', __('Failed to load available slots'));
        }
    }

    public function eventClick($event)
    {
        $this->emit('showAppointmentDetails', $event['id']);
    }

    public function select($selection)
    {
        $this->emit('createAppointment', [
            'start' => $selection['start'],
            'end' => $selection['end'],
            'allDay' => $selection['allDay'] ?? false,
        ]);
    }

    public function getStatusesProperty()
    {
        return collect(AppointmentStatus::cases())->mapWithKeys(fn ($status) => [
            $status->value => $status->getLabel()
        ]);
    }

    public function getTypesProperty()
    {
        return collect(AppointmentTypeEnum::cases())->mapWithKeys(fn ($type) => [
            $type->value => $type->getLabel()
        ]);
    }

    public function render()
    {
        return view('saluteora::livewire.calendar', [
            'statuses' => $this->statuses,
            'types' => $this->types,
        ]);
    }
}
