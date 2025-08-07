# Errore: CSRF Token Expired in Livewire Widget

## Descrizione
L'errore 419 (Page Expired) si verifica quando si interagisce con i select nel widget `FindDoctorAndAppointmentWidget`. Questo è causato dalla mancanza o invalidità del token CSRF di Laravel.

## Contesto
Il widget `FindDoctorAndAppointmentWidget` utilizza Livewire per gestire le interazioni dinamiche. Quando un utente interagisce con i select, Livewire invia una richiesta AJAX che richiede un token CSRF valido.

## Cause Comuni
1. Token CSRF mancante nella vista Blade
2. Token CSRF scaduto
3. Mismatch tra il token nel form e quello nella sessione
4. Problemi di cache del browser

## Impatto
- Impossibilità di interagire con i select
- Interruzione del flusso di prenotazione
- Esperienza utente negativa

## Soluzione
1. Assicurarsi che il meta tag CSRF sia presente nel layout principale:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

2. Verificare che il widget Livewire sia correttamente inizializzato:
```php
@livewire('find-doctor-and-appointment-widget')
```

3. Aggiungere il token CSRF nella vista del widget:
```php
<div>
    @csrf
    {{ $slot }}
</div>
```

4. Verificare che il middleware `VerifyCsrfToken` sia attivo per le route Livewire.

## Best Practices
1. Utilizzare sempre il meta tag CSRF nel layout principale
2. Verificare la presenza del token in tutte le form Livewire
3. Implementare gestione degli errori CSRF
4. Mantenere aggiornate le dipendenze Livewire

## Collegamenti Correlati
- [Documentazione Livewire](https://livewire.laravel.com/docs/security)
- [Documentazione Laravel CSRF](https://laravel.com/docs/csrf)
- [Widget Implementation](../../app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php)

## Esempio di Correzione
```php
// resources/views/layouts/app.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
</head>
<body>
    {{ $slot }}
    @livewireScripts
</body>
</html>

// resources/views/filament/widgets/find-doctor-and-appointment.blade.php
<div>
    @csrf
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>
</div>
```

## Checklist di Verifica
- [ ] Meta tag CSRF presente nel layout
- [ ] Token CSRF presente nella vista del widget
- [ ] Middleware VerifyCsrfToken attivo
- [ ] Dipendenze Livewire aggiornate
- [ ] Cache del browser pulita 