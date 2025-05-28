# Guida: Calendario con Date Selezionabili in appointment_date (FindDoctorAndAppointmentWidget)

## Obiettivo
Mostrare nello step `getDateStep` del widget un calendario che consente la selezione **solo** delle date effettivamente disponibili (tutte le altre disabilitate), secondo la logica di business sanitaria e multi-tenant.

---

## 1. Scelta del Componente
- Usare `DatePicker` di Filament (o un wrapper custom se serve maggiore controllo)
- Opzione `disabledDates()` per disabilitare date dinamicamente
- Opzione `enabledDates()` (se disponibile) per abilitare solo alcune date
- Se serve, estendere il componente con JS custom (es. Flatpickr hooks)

## 2. Passaggio delle Date Disponibili
- Calcolare le date disponibili lato backend (es. in un metodo del widget, action, service)
- Passare l'array di date disponibili al DatePicker tramite prop, Livewire property, computed o closure
- Esempio:
  ```php
  DatePicker::make('appointment_date')
      ->label('saluteora::fields.appointment_date')
      ->minDate(now())
      ->maxDate(now()->addMonths(3))
      ->required()
      ->native(false)
      ->displayFormat('d/m/Y')
      ->disabledDates(fn () => $this->getDisabledDates())
  ```
- Dove `getDisabledDates()` restituisce un array di date da disabilitare (ISO8601)

## 3. Logica di Business
- Le date disponibili devono rispettare:
  - Orari lavorativi dello studio (lun-sab, 8-19)
  - Ferie, chiusure, festività
  - Slot già occupati (no overbooking)
  - Limiti di prenotazione (es. max 3 mesi avanti, min 1 giorno di anticipo)
- Esempio di calcolo:
  ```php
  protected function getDisabledDates(): array
  {
      $allDates = CarbonPeriod::create(now(), now()->addMonths(3));
      $disabled = [];
      foreach ($allDates as $date) {
          if (!$this->isDateBookable($date)) {
              $disabled[] = $date->toDateString();
          }
      }
      return $disabled;
  }
  ```

## 4. Integrazione Backend
- Se la logica è complessa, delegare a una Action/Service (es. FetchBookableDatesAction)
- Caching: cache delle date disponibili per studio/utente/periodo (es. 1h)
- Multi-tenant: filtrare per studio corrente (Filament::getTenant())
- Performance: evitare query N+1, usare eager loading

## 5. UX e Accessibilità
- Mostrare loading spinner se le date sono calcolate async
- Feedback chiaro se nessuna data è disponibile
- Tooltip/aria-label sulle date disabilitate ("Non prenotabile")
- Navigazione tastiera e screen reader

## 6. Best Practice
- Centralizzare la logica di calcolo date disponibili
- Documentare la policy in docs/ e .mdc
- Scrivere test automatici (unit, feature, browser)
- Aggiornare la documentazione ogni volta che cambia la logica

## 7. Esempio Completo
```php
protected function getDateStep(): array
{
    return [
        'appointment_date' => DatePicker::make('appointment_date')
            ->label('saluteora::fields.appointment_date')
            ->minDate(now())
            ->maxDate(now()->addMonths(3))
            ->required()
            ->native(false)
            ->displayFormat('d/m/Y')
            ->disabledDates(fn () => $this->getDisabledDates()),
        // ...
    ];
}

protected function getDisabledDates(): array
{
    // Esempio: calcolo date non prenotabili
    $allDates = CarbonPeriod::create(now(), now()->addMonths(3));
    $disabled = [];
    foreach ($allDates as $date) {
        if (!$this->isDateBookable($date)) {
            $disabled[] = $date->toDateString();
        }
    }
    return $disabled;
}

protected function isDateBookable(Carbon $date): bool
{
    // Logica: solo lun-sab, no festivi, no ferie, no slot pieni
    if ($date->isSunday()) return false;
    // ... altre regole ...
    return true;
}
```

## 8. Consigli Avanzati
- Per grandi dataset, caricare le date disponibili via AJAX (Livewire/Alpine)
- Per studi con regole diverse, parametrizzare la logica (es. orari, ferie)
- Per performance, usare cache per studio/periodo
- Per sicurezza, validare lato backend la data scelta

## 9. Testing
- Testare che solo le date giuste siano selezionabili
- Testare edge case (tutte le date occupate, ferie, limiti)
- Test browser: navigazione, accessibilità, feedback

## 10. Propagazione e Documentazione
- Aggiornare docs/ e .mdc con la policy
- Collegare la guida a tutte le risorse che usano la logica
- Aggiornare la documentazione ogni volta che cambia la regola

---

**Collegamenti:**
- [Filament DatePicker Docs](https://filamentphp.com/docs/3.x/forms/fields/date-picker)
- [CarbonPeriod](https://carbon.nesbot.com/docs/#api-period)
- [Policy di booking SaluteOra](./booking-policy.md)
- [Best practice multi-tenant](./multi-tenancy.md)
- [Testing UI](./testing-ui.md)

---

> Questa guida va mantenuta aggiornata e linkata in tutte le policy di booking e nei file .mdc di windsurf/cursor. 