<div class="text-sm text-gray-700 space-y-2">
    <p><strong>Nome:</strong> {{ $appointment->patient?->full_name }}</p>
    <p><strong>Data:</strong> {{ $appointment->starts_at?->format('d F Y') }}</p>
    <p><strong>Orario:</strong> {{ $appointment->time_range }}</p>
    @if($appointment->patient?->phone)
        <p><strong>Cellulare:</strong> {{ $appointment->patient?->phone }}</p>
    @endif
    @if($appointment->patient?->email)
        <p><strong>Email:</strong> {{ $appointment->patient?->email }}</p>
    @endif
    @if($appointment->notes)
        <p><strong>Note:</strong> {{ $appointment->notes }}</p>
    @endif
</div>
    
