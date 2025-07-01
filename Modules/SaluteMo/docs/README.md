# Modulo SaluteMo

Modulo principale per la gestione del sistema sanitario SaluteMo, che include funzionalità per pazienti, medici e amministratori di studi medici.

## Componenti Principali

### Widget Filament
- `FindDoctorAndAppointmentWidget` - Widget per ricerca medici e prenotazione appuntamenti
- `PatientDashboardWidget` - Dashboard paziente
- `DoctorCalendarWidget` - Calendario medico

### Componenti UI
- `InlineDatePicker` - Selettore date integrato per form Filament

## Documentazione Tecnica

### Ottimizzazioni e Performance
- **[InlineDatePicker: Ottimizzazione Livewire](./inline-date-picker-livewire-optimization.md)** - Analisi approfondita dell'implementazione Livewire per la validazione delle date, incluso approccio ibrido e considerazioni per ambiente sanitario.

### Architettura
- [Services Architecture](./services-architecture.md)
- [Widget Documentation](./widgets-documentation.md)
- [Data Transfer Objects](./data-objects.md)

## Collegamenti Globali

- [Documentazione Root: InlineDatePicker Optimization](../../../docs/inline-date-picker-optimization.md)
- [Regole Laraxot](../../../docs/laraxot_conventions.md)
- [Best Practices Filament](../../../docs/filament-best-practices.md)

## Features Principali

1. **Gestione Appuntamenti Real-Time**
   - Controllo disponibilità dinamica
   - Prevenzione doppia prenotazione
   - Cache intelligente per performance

2. **Multi-Tenant per Studi Medici**
   - Isolamento dati per studio
   - Gestione ruoli medici/pazienti
   - Dashboard specifiche per ruolo

3. **Integrazione Sanitaria**
   - Validazione orari clinici
   - Gestione emergenze
   - Audit trail completo

## Configurazione

Le configurazioni principali sono in `config/saluteora.php` e includono:
- Validazione date picker (payload/livewire/hybrid)
- Cache TTL per disponibilità
- Limiti temporali prenotazioni
- Configurazioni ambiente sanitario

## Testing

Eseguire i test del modulo:
```bash
php artisan test Modules/SaluteMo/Tests/
```

Test di performance per date picker:
```bash
php artisan test --filter=DatePickerPerformanceTest
``` 