<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Components;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

/**
 * InlineDatePicker - A customizable inline date picker component
 * 
 * Features:
 * - Month navigation with previous/next buttons
 * - Configurable enabled/disabled dates
 * - Customizable styling
 * - Localization support
 * - Keyboard navigation
 */
class InlineDatePicker extends Field
{
    protected string $view = 'ui::filament.components.inline-date-picker';

    protected array|Closure $enabledDates = [];
    
    protected string $highlightColor = 'bg-indigo-600';
    
    protected CarbonInterface $displayDate;
    
    protected bool $showWeekNumbers = false;
    
    protected string $firstDayOfWeek = 'monday';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->displayDate = now()->startOfMonth();
        
        $this->afterStateHydrated(function (self $component, $state): void {
            if ($state) {
                $component->displayDate = Carbon::parse($state)->startOfMonth();
            }
        });
        
        $this->dehydrateStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('Y-m-d') : null);
    }
    
    /**
     * Set the enabled dates that can be selected
     */
    public function enabledDates(array|Closure $dates): static
    {
        $this->enabledDates = $dates;
        
        return $this;
    }
    
    /**
     * Get the enabled dates
     */
    public function getEnabledDates(): array
    {
        $enabledDates = $this->evaluate($this->enabledDates);
        
        if ($enabledDates instanceof Collection) {
            $enabledDates = $enabledDates->toArray();
        }
        
        return is_array($enabledDates) ? $enabledDates : [];
    }
    
    /**
     * Set the highlight color for selected dates
     */
    public function highlightColor(string $color): static
    {
        $this->highlightColor = $color;
        
        return $this;
    }
    
    /**
     * Generate the calendar data structure
     */
    public function generateCalendarData(): array
    {
        $firstDay = $this->displayDate->copy()->startOfMonth()->startOfWeek($this->firstDayOfWeek);
        $lastDay = $this->displayDate->copy()->endOfMonth()->endOfWeek($this->firstDayOfWeek);
        
        $enabledDates = $this->getEnabledDates();
        $hasEnabledDates = !empty($enabledDates);
        
        $weeks = [];
        $currentDay = $firstDay->copy();
        
        while ($currentDay->lte($lastDay)) {
            $week = [];
            
            for ($i = 0; $i < 7; $i++) {
                $isCurrentMonth = $currentDay->month === $this->displayDate->month;
                $dateString = $currentDay->format('Y-m-d');
                
                $week[] = [
                    'date' => $dateString,
                    'day' => $currentDay->day,
                    'isCurrentMonth' => $isCurrentMonth,
                    'isToday' => $currentDay->isToday(),
                    'isEnabled' => $hasEnabledDates ? in_array($dateString, $enabledDates) : true,
                    'isSelected' => $this->getState() === $dateString,
                ];
                
                $currentDay->addDay();
            }
            
            $weeks[] = $week;
        }
        
        return [
            'month' => $this->displayDate->translatedFormat('F'),
            'year' => $this->displayDate->year,
            'weeks' => $weeks,
            'hasPreviousMonth' => $this->hasPreviousMonth(),
            'hasNextMonth' => $this->hasNextMonth(),
        ];
    }
    
    /**
     * Check if there's a previous month with enabled dates
     */
    protected function hasPreviousMonth(): bool
    {
        $enabledDates = $this->getEnabledDates();
        
        if (empty($enabledDates)) {
            return true;
        }
        
        $firstDayOfCurrentMonth = $this->displayDate->copy()->startOfMonth();
        
        foreach ($enabledDates as $date) {
            $date = Carbon::parse($date);
            if ($date->lt($firstDayOfCurrentMonth)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check if there's a next month with enabled dates
     */
    protected function hasNextMonth(): bool
    {
        $enabledDates = $this->getEnabledDates();
        
        if (empty($enabledDates)) {
            return true;
        }
        
        $lastDayOfCurrentMonth = $this->displayDate->copy()->endOfMonth();
        
        foreach ($enabledDates as $date) {
            $date = Carbon::parse($date);
            if ($date->gt($lastDayOfCurrentMonth)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Navigate to the previous month
     */
    public function previousMonth(): void
    {
        $this->displayDate->subMonthNoOverflow();
        $this->dispatch('inline-date-picker-updated', id: $this->getId());
    }
    
    /**
     * Navigate to the next month
     */
    public function nextMonth(): void
    {
        $this->displayDate->addMonthNoOverflow();
        $this->dispatch('inline-date-picker-updated', id: $this->getId());
    }
    
    /**
     * Set the current view month from the frontend
     */
    public function setDisplayDate(string $date): void
    {
        $this->displayDate = Carbon::parse($date);
    }
    
    /**
     * Set the first day of the week
     */
    public function firstDayOfWeek(string $day): static
    {
        $this->firstDayOfWeek = strtolower($day);
        
        return $this;
    }
    
    /**
     * Show week numbers
     */
    public function showWeekNumbers(bool $show = true): static
    {
        $this->showWeekNumbers = $show;
        
        return $this;
    }
    
    /**
     * Get the view data for the component
     */
    public function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'calendar' => $this->generateCalendarData(),
            'highlightColor' => $this->highlightColor,
            'showWeekNumbers' => $this->showWeekNumbers,
            'daysOfWeek' => $this->getDaysOfWeek(),
        ]);
    }
    
    /**
     * Get the localized days of the week
     */
    protected function getDaysOfWeek(): array
    {
        $firstDay = Carbon::parse('next ' . $this->firstDayOfWeek);
        
        return collect(range(0, 6))->map(function ($day) use ($firstDay) {
            return $firstDay->copy()->addDays($day)->translatedFormat('D');
        })->toArray();
    }
}
