@php
    $isApproved = $workflow->isModerationApproved();
    $doctor = $workflow->doctor;
@endphp

<x-mail::message>
# {{ $isApproved ? 'Registrazione Approvata' : 'Aggiornamento Registrazione' }}

Gentile Dott. {{ $doctor->full_name }},

@if($isApproved)
La sua richiesta di registrazione è stata approvata.
Per completare il processo di registrazione e accedere a tutte le funzionalità del portale, la preghiamo di cliccare sul pulsante sottostante:

<x-mail::button :url="$continueUrl">
Completa Registrazione
</x-mail::button>

Il link rimarrà valido per le prossime 48 ore.
@else
La sua richiesta di registrazione è attualmente in fase di revisione.

@if($workflow->moderation_notes)
Note aggiuntive:
{{ $workflow->moderation_notes }}
@endif

La contatteremo non appena avremo completato la revisione dei suoi dati.
@endif

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message> 