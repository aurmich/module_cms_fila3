# Gestione Disponibilità Medici

## Concetto Fondamentale

Nel sistema SaluteOra, la gestione delle disponibilità dei medici si basa su un principio di unificazione: **tutti gli slot temporali, sia disponibilità che appuntamenti effettivi, sono gestiti attraverso il modello `Appointment`**.

## Modello Dati

### Utilizzo di `Appointment` per le Disponibilità

Il modello `Appointment` viene utilizzato sia per gli appuntamenti con i pazienti che per definire le disponibilità dei medici, con la seguente configurazione:

```php
// Per le disponibilità dei medici
Appointment::create([
    'doctor_id' => $doctorId,
    'studio_id' => $studioId,
    'type' => AppointmentTypeEnum::AVAILABILITY->value,
    'status' => AppointmentStatusEnum::AVAILABLE->value,
    'start_time' => $startTime,
    'end_time' => $endTime,
    'title' => 'Disponibilità',
    'patient_id' => null, // Nessun paziente associato
]);
```

### Vantaggi dell'Approccio Unificato

1. **Semplificazione del modello dati**: un'unica tabella per gestire tutti gli eventi del calendario
2. **Prevenzione di conflitti**: facile verifica di sovrapposizioni tra disponibilità e appuntamenti
3. **Gestione coerente**: utilizzo di enum per type e status garantisce consistenza
4. **Migliore UX**: visualizzazione unificata nel calendario per medici e staff

## Implementazione nella UI

### 1. Widget del Calendario

Il widget FullCalendar deve essere configurato per:

- Mostrare le disponibilità dei medici con un colore specifico
- Permettere di creare/modificare/eliminare disponibilità
- Distinguere visivamente tra disponibilità e appuntamenti con pazienti

### 2. Pagina di Gestione Disponibilità

La pagina `DoctorAvailabilityCalendar` deve:

- Visualizzare solo le disponibilità e gli appuntamenti del medico corrente
- Permettere di definire slot di disponibilità ricorrenti
- Facilitare l'approvazione o il rifiuto degli appuntamenti richiesti dai pazienti

## Linee Guida per l'Implementazione

### Corretta

```php
// Ottenere disponibilità e appuntamenti dal modello Appointment
$availabilities = Appointment::query()
    ->where('doctor_id', $doctorId)
    ->where(function ($query) {
        $query->where('type', AppointmentTypeEnum::AVAILABILITY->value)
              ->orWhere('type', AppointmentTypeEnum::CONSULTATION->value);
    })
    ->get();
```

### Errata

```php
// NON creare un modello o tabella separata per le disponibilità
$availabilities = DoctorAvailability::where('doctor_id', $doctorId)->get();
```

## Transizione di Stato

Quando un paziente prenota un appuntamento in uno slot disponibile:

1. Creare un nuovo `Appointment` per il paziente
2. Aggiornare o rimuovere l'`Appointment` di disponibilità corrispondente
3. Notificare il medico della nuova richiesta di appuntamento

## API per la Gestione delle Disponibilità

```php
// Verificare se un dottore è disponibile in un determinato orario
public function isDoctorAvailable(Doctor $doctor, Carbon $startTime, Carbon $endTime): bool
{
    return Appointment::query()
        ->where('doctor_id', $doctor->id)
        ->where('type', AppointmentTypeEnum::AVAILABILITY->value)
        ->where('status', AppointmentStatusEnum::AVAILABLE->value)
        ->where('start_time', '<=', $startTime)
        ->where('end_time', '>=', $endTime)
        ->exists();
}
```

## Note Importanti

1. **MAI** creare una tabella o modello separato per le disponibilità dei medici
2. **SEMPRE** utilizzare il modello `Appointment` con i tipi e stati appropriati
3. Verificare sempre che non ci siano sovrapposizioni quando si creano nuove disponibilità
4. Utilizzare transazioni per operazioni che modificano più record

## [AGGIORNAMENTO 2024-06-XX] - Disponibilità solo su appointments

**Regola fondamentale:**
- Le disponibilità dei dottori vanno gestite solo tramite la tabella `appointments` (con `patient_id` null o flag dedicato).
- È vietato creare tabelle o modelli separati (es. doctor_availabilities) per le disponibilità.
- Tutto il calendario (FullCalendar/Filament) lavora su appointments, distinguendo tra disponibilità e appuntamenti tramite i campi esistenti.

**Motivazione:**
- Filosofia: un solo punto di verità, nessuna duplicazione, serenità del codice.
- Logica: DRY, KISS, nessun lock-in, massima compatibilità con FullCalendar e Filament.
- Religione: non avrai altro modello di disponibilità all'infuori di Appointment.
- Politica: ogni modulo è autonomo, ma rispetta la centralizzazione delle entità.
- Zen: serenità, nessun errore di sync, nessuna tabella fantasma, nessun refactor doloroso.

**Checklist aggiornata:**
- Gestire sempre le disponibilità tramite appointments
- Vietato creare/gestire tabelle o modelli separati per le disponibilità
- Aggiornare la documentazione ogni volta che si modifica la logica di disponibilità/appuntamenti
- Seguire sempre la filosofia DRY, KISS, centralizzazione

**Collegamenti:**
- [../appointment-management.md](../appointment-management.md)
- [widgets/doctor-calendar-widget.md](widgets/doctor-calendar-widget.md)
- [../fullcalendar_parental_widgets.md](../fullcalendar_parental_widgets.md)
