<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Calendar;

use Spatie\QueueableAction\QueueableAction;
use Carbon\CarbonInterface;
use Carbon\Carbon;

class GetCalendarConfigAction
{
    use QueueableAction;

    /**
     * Get calendar configuration
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public function execute(array $overrides = []): array
    {
        $config = [
            'locale' => app()->getLocale(),
            'timezone' => config('app.timezone'),
            'firstDay' => 1, // Monday
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'buttonText' => [
                'today' => __('saluteora::app.today'),
                'month' => __('saluteora::app.month'),
                'week' => __('saluteora::app.week'),
                'day' => __('saluteora::app.day'),
                'list' => __('saluteora::app.list'),
            ],
            'businessHours' => $this->getBusinessHours(),
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
            'slotDuration' => '00:15:00',
            'slotMinTime' => '07:00:00',
            'slotMaxTime' => '21:00:00',
            'allDaySlot' => false,
            'nowIndicator' => true,
            'editable' => false,
            'selectable' => false,
            'selectMirror' => true,
            'dayMaxEvents' => true,
            'height' => 'auto',
            'contentHeight' => 'auto',
            'aspectRatio' => 1.8,
            'eventClassNames' => ['cursor-pointer'],
        ];

        return array_merge($config, $overrides);
    }

    /**
     * Get business hours configuration
     *
     * @return array<string, mixed>
     */
    protected function getBusinessHours(): array
    {
        return [
            'daysOfWeek' => [1, 2, 3, 4, 5], // Monday to Friday
            'startTime' => '08:00',
            'endTime' => '19:00',
        ];
    }

    /**
     * Get available time slots
     *
     * @param  CarbonInterface  $date
     * @param  int  $durationInMinutes
     * @return array<array{start: string, end: string}>
     */
    public function getAvailableTimeSlots(
        CarbonInterface $date,
        int $durationInMinutes = 30
    ): array {
        $businessHours = $this->getBusinessHours();
        $dayOfWeek = $date->dayOfWeekIso;

        // Skip weekends if not in business days
        if (!in_array($dayOfWeek, $businessHours['daysOfWeek'])) {
            return [];
        }

        $startTime = $date->copy()->setTimeFromTimeString($businessHours['startTime']);
        $endTime = $date->copy()->setTimeFromTimeString($businessHours['endTime']);

        $slots = [];
        $currentSlot = $startTime->copy();

        while ($currentSlot->copy()->addMinutes($durationInMinutes) <= $endTime) {
            $slotEnd = $currentSlot->copy()->addMinutes($durationInMinutes);

            $slots[] = [
                'start' => $currentSlot->toDateTimeString(),
                'end' => $slotEnd->toDateTimeString(),
            ];

            $currentSlot->addMinutes($durationInMinutes);
        }

        return $slots;
    }
}
