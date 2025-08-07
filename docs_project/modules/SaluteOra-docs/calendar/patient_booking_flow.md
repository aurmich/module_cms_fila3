# Patient Booking Calendar Flow

## Overview

The patient booking calendar allows users to view available time slots and book appointments with their chosen dental clinic. The implementation uses FullCalendar with a custom backend to handle the specific requirements of dental appointment scheduling.

## Key Features

1. **Clinic Selection**
   - Patients must first select a dental clinic
   - Only available clinics are shown based on the patient's location and preferences

2. **Calendar View**
   - Shows available days with visual indicators
   - Highlights days with available slots
   - Shows fully booked or unavailable days

3. **Time Slot Selection**
   - Displays available time slots when a day is selected
   - Shows duration and type of available appointments
   - Handles real-time availability

## Technical Implementation

### Frontend Components

1. **FullCalendar Integration**
   - Uses FullCalendar v6+ with React integration
   - Custom plugins for clinic-specific availability
   - Responsive design for mobile and desktop

2. **Data Flow**
   ```mermaid
   sequenceDiagram
       Patient->>+Frontend: Selects clinic
       Frontend->>+Backend: Fetch available days (GET /api/availability/days?clinic_id=X)
       Backend-->>-Frontend: ["2024-06-01", "2024-06-02", ...]
       
       Patient->>+Frontend: Clicks on available day
       Frontend->>+Backend: Fetch time slots (GET /api/availability/slots?clinic_id=X&date=2024-06-01)
       Backend-->>-Frontend: [{time: "09:00", type: "checkup"}, ...]
       
       Patient->>+Frontend: Selects time slot
       Frontend->>+Backend: Book appointment (POST /api/appointments)
       Backend-->>-Frontend: { success: true, appointment: {...} }
   ```

### Backend Implementation

1. **Fetching Available Days**
   ```php
   // Example controller method
   public function getAvailableDays(Request $request)
   {
       $request->validate([
           'clinic_id' => 'required|exists:clinics,id',
           'start_date' => 'date',
           'end_date' => 'date|after:start_date',
       ]);

       $clinic = Clinic::findOrFail($request->clinic_id);
       $startDate = $request->input('start_date', now()->toDateString());
       $endDate = $request->input('end_date', now()->addMonths(3)->toDateString());

       return response()->json(
           $clinic->getAvailableDays($startDate, $endDate)
       );
   }
   ```

2. **Fetching Time Slots**
   ```php
   public function getAvailableSlots(Request $request)
   {
       $request->validate([
           'clinic_id' => 'required|exists:clinics,id',
           'date' => 'required|date',
       ]);

       $clinic = Clinic::findOrFail($request->clinic_id);
       
       return response()->json(
           $clinic->getAvailableSlots($request->date)
       );
   }
   ```

## FullCalendar Configuration

```javascript
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

const calendarEl = document.getElementById('booking-calendar');
const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    // Custom configuration for patient booking
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    // ... other configuration options
});
```

## Error Handling

1. **Common Error Scenarios**
   - Clinic not found
   - No availability for selected date
   - Time slot already booked
   - Invalid date/time format

2. **Error Response Format**
   ```json
   {
       "error": {
           "code": "time_slot_unavailable",
           "message": "The selected time slot is no longer available",
           "available_slots": ["10:00", "11:30", "14:00"]
       }
   }
   ```

## Performance Considerations

1. **Caching**
   - Cache clinic availability for 15 minutes
   - Use cache tags for easy invalidation
   - Implement ETag for unchanged responses

2. **Database Optimization**
   - Index clinic_id and date fields
   - Use query optimization for availability checks
   - Consider read replicas for high traffic

## Security Considerations

1. **Rate Limiting**
   - Implement rate limiting for API endpoints
   - Use API tokens for authenticated requests
   - Validate all input parameters

2. **Data Protection**
   - Ensure patient data is properly scoped
   - Implement proper authorization checks
   - Log all booking attempts

## Related Documentation

- [FullCalendar Documentation](https://fullcalendar.io/docs)
- [Laravel API Resources](https://laravel.com/docs/eloquent-resources)
- [Patient Management](./patient_management.md)
- [Calendar Widgets](../calendar-widgets.md)
