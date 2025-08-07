# Policy di Navigazione: Gruppo "Agenda" per Appuntamenti

## Filosofia
- Tutte le funzionalità relative ad appuntamenti (flusso, calendario, disponibilità) DEVONO essere nello stesso gruppo di menu: **Agenda**.
- L'utente non deve mai segnalare incoerenze: la policy è automatica e centralizzata.

## Logica
- La chiave `'group' => 'Agenda'` va usata in tutte le traduzioni di risorse, pagine e widget appuntamenti.
- Nessuna stringa hardcoded, nessun gruppo diverso.

## Motivazione
- UX coerente, onboarding immediato, nessuna dispersione.
- Refactoring e manutenzione semplificati.

## File coinvolti
- `appointment.php`
- `appointment_workflow.php`
- `doctor_availability_calendar.php`
- `doctor_availability.php`

## Pattern
```php
'navigation' => [
    'label' => 'Calendario Appuntamenti',
    'group' => 'Agenda',
    ...
],
```

## Collegamenti
- [README.md](README.md)
- [.cursor/rules/navigation_group_agenda_policy.mdc](../../.cursor/rules/navigation_group_agenda_policy.mdc)
- [.windsurf/rules/navigation_group_agenda_policy.mdc](../../.windsurf/rules/navigation_group_agenda_policy.mdc)

## Ultimo aggiornamento
2025-06-05
