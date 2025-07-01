<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SaluteOra\Actions\Calendar\FetchCalendarEventsAction;
use Modules\SaluteOra\Actions\Calendar\GetCalendarConfigAction;

class CalendarController extends Controller
{
    public function __construct(
        protected FetchCalendarEventsAction $fetchEvents,
        protected GetCalendarConfigAction $getConfig
    ) {}

    /**
     * Get calendar events
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function events(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'filters' => 'nullable|array',
            'filters.*' => 'nullable|string',
        ]);

        $start = Carbon::parse($validated['start']);
        $end = Carbon::parse($validated['end']);
        $filters = $validated['filters'] ?? [];

        $events = $this->fetchEvents->execute($start, $end, $filters);

        return response()->json($events);
    }

    /**
     * Get calendar configuration
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function config(Request $request): JsonResponse
    {
        $config = $this->getConfig->execute([
            'locale' => app()->getLocale(),
            'timezone' => config('app.timezone'),
        ]);

        return response()->json($config);
    }

    /**
     * Get available time slots
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function availableSlots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'duration' => 'nullable|integer|min:1',
        ]);

        $date = Carbon::parse($validated['date']);
        $duration = $validated['duration'] ?? 30;

        $slots = $this->getConfig->getAvailableTimeSlots($date, $duration);

        return response()->json($slots);
    }
}
