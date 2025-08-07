# Errore 419 Page Expired nei Select Livewire

## Descrizione
L'errore 419 Page Expired si verifica quando si interagisce con i componenti Select in un widget Livewire. Questo errore indica che il token CSRF non è valido o è scaduto.

## Contesto
Il problema si verifica specificamente nel widget `FindDoctorAndAppointmentWidget` quando si interagisce con i select per:
- Regione
- Città
- CAP

## Cause
1. Il token CSRF non viene correttamente inizializzato nel widget
2. La vista non include correttamente il token CSRF
3. Il form non è correttamente configurato per gestire le richieste AJAX di Livewire

## Soluzione
1. Rimuovere la proprietà `$view` dalla classe base `XotBaseWidget` poiché è specifica per ogni widget
2. Utilizzare il trait `HasCsrfToken` per gestire il token CSRF
3. Configurare correttamente il form per gestire le richieste AJAX

## Implementazione
```php
// Nel widget
use Modules\Xot\Traits\HasCsrfToken;

class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    use HasCsrfToken;
    
    protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';
}

// Nella vista
<div>
    <form wire:submit.prevent="submit">
        @csrf
        {{ $this->form }}
    </form>
</div>
```

## Best Practices
1. Utilizzare sempre il trait `HasCsrfToken` per i widget Livewire
2. Mantenere la vista del widget minimale e pulita
3. Verificare che il form sia correttamente configurato per le richieste AJAX
4. Non duplicare la proprietà `$view` tra classe base e widget

## Collegamenti Correlati
- [Documentazione Livewire CSRF](https://livewire.laravel.com/docs/security)
- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/advanced#livewire)
- [XotBaseWidget Implementation](../xot_base_classes.md)

## Checklist di Verifica
- [ ] Widget utilizza il trait HasCsrfToken
- [ ] Vista include correttamente il token CSRF
- [ ] Form è configurato per le richieste AJAX
- [ ] Non ci sono duplicazioni della proprietà $view 