# Stati degli Appuntamenti - SaluteOra

## Panoramica

Il sistema di gestione degli stati degli appuntamenti utilizza il pattern State Machine di Spatie per gestire il ciclo di vita degli appuntamenti medici.

## Stati Implementati

### 1. Pending (In attesa)
- **Stato di default** per nuovi appuntamenti
- Il paziente ha prenotato ma deve ancora confermare
- **Transizioni possibili**: Confirmed, Rejected (NON Cancelled - da Pending non si può cancellare direttamente)
- **Colore**: warning
- **Icona**: heroicon-o-clock

### 2. Confirmed (Confermato)
- Paziente ha confermato la richiesta di appuntamento
- **Transizioni possibili**: ReportPending, Cancelled, NoShow
- **Colore**: success
- **Icona**: heroicon-o-check-circle

### 3. ReportPending (Referto in Attesa)
- Appuntamento confermato e inserito nel calendario
- **Transizioni possibili**: ReportCompleted
- **Colore**: warning
- **Icona**: heroicon-o-document-text
- **Modificabile**: true
- **Attivo**: true

### 4. ReportCompleted (Referto Completato)
- Referto medico completato
- **Transizioni possibili**: RefundPending, ProBono
- **Colore**: success
- **Icona**: heroicon-o-document-check
- **Completato**: true

### 5. RefundPending (Rimborso in Attesa)
- Rimborso in attesa di elaborazione
- **Transizioni possibili**: RefundAccepted, RefundIntegrate, RefundCompleted
- **Colore**: warning
- **Icona**: heroicon-o-currency-euro

### 6. RefundAccepted (Rimborso Accettato)
- Rimborso accettato e in elaborazione
- **Transizioni possibili**: RefundCompleted
- **Colore**: success
- **Icona**: heroicon-o-check-circle

### 7. RefundIntegrate (Rimborso da Integrare)
- Rimborso che deve essere integrato con altri servizi
- **Transizioni possibili**: RefundCompleted
- **Colore**: info
- **Icona**: heroicon-o-arrow-path-20-solid

### 8. RefundCompleted (Rimborso Completato)
- Rimborso completato e pagato
- **Stato finale** - nessuna transizione possibile
- **Colore**: success
- **Icona**: heroicon-o-banknotes
- **Completato**: true

### 9. ProBono (Servizio Gratuito)
- Appuntamento erogato come servizio gratuito
- **Stato finale** - nessuna transizione possibile
- **Colore**: info
- **Icona**: heroicon-o-heart
- **Completato**: true

### 10. Cancelled (Annullato)
- Appuntamento annullato
- **Colore**: danger
- **Icona**: heroicon-o-x-circle

### 11. Rejected (Rifiutato)
- Appuntamento rifiutato dal dottore o sistema
- **Transizioni possibili**: Confirmed (in caso di revisione della decisione)
- **Colore**: danger
- **Icona**: heroicon-o-x-mark

### 12. NoShow (Assente)
- Paziente non si è presentato
- **Transizioni possibili**: Banned
- **Colore**: danger
- **Icona**: heroicon-o-exclamation-circle

### 13. Banned (Bannato)
- Utente bannato dal sistema per violazioni
- **Colore**: danger
- **Icona**: heroicon-o-no-symbol

### 14. Rescheduled (Riprogrammato)
- Appuntamento spostato a nuovo orario
- **Colore**: info
- **Icona**: heroicon-o-arrow-path-20-solid
- **Modificabile**: true

## Diagramma delle Transizioni

```
Pending → Confirmed → ReportPending → ReportCompleted → RefundPending → RefundAccepted → RefundCompleted
   ↓         ↓           ↓              ↓                ↓
   ↓      Cancelled   ReportCompleted ProBono        RefundIntegrate → RefundCompleted
Rejected ↔ Confirmed   ↑
            ↓          
          Rescheduled ← Scheduled
                        ↓
                    Cancelled

NoShow → Banned
```

**Nota importante**: Da `Pending` si può andare solo a `Confirmed` o `Rejected`. 
La cancellazione diretta da `Pending` non è permessa - un appuntamento in attesa deve essere prima confermato o rifiutato.

## Implementazione

### Classe Base: AppointmentState
```php
abstract class AppointmentState extends State
{
    abstract public function label(): string;
    abstract public function color(): string;
    abstract public function icon(): string;
    
    public function canBeModified(): bool { return false; }
    public function isActive(): bool { return false; }
    public function isPending(): bool { return false; }
    public function isCompleted(): bool { return false; }
}
```

### BaseTransition per Appuntamenti
Estende il pattern BaseTransition con:
- Notifiche automatiche a paziente e dottore
- Dati contestuali (data appuntamento, nomi, etc.)
- Gestione automatica del cambio stato

### Transizioni Implementate
- `PendingToConfirmed`
- `PendingToRejected`
- `ConfirmedToReportPending`
- `ConfirmedToCancelled`
- `ConfirmedToNoShow`
- `NoShowToBanned`
- `ReportPendingToReportCompleted`
- `ReportCompletedToRefundPending`
- `ReportCompletedToProBono`
- `RefundPendingToRefundAccepted`
- `RefundPendingToRefundIntegrate`
- `RefundPendingToRefundCompleted`
- `RefundAcceptedToRefundCompleted`
- `RefundIntegrateToRefundCompleted`

## Pattern di Utilizzo

```php
// Cambio stato con transizione
$appointment->state->transitionTo(Confirmed::class, 'Confermato dal paziente');

// Controllo proprietà stato
if ($appointment->state->canBeModified()) {
    // Appuntamento modificabile
}

if ($appointment->state->isActive()) {
    // Appuntamento attivo
}

// Accesso alle proprietà dello stato
$color = $appointment->state->color();
$icon = $appointment->state->icon();
$label = $appointment->state->label();
```

## Notifiche Automatiche

Le transizioni inviano automaticamente notifiche via email a:
- **Paziente**: Per tutte le transizioni
- **Dottore**: Per tutte le transizioni

### Dati Inclusi nelle Notifiche
- Messaggio personalizzato
- Data e ora appuntamento
- Nome paziente
- Nome dottore
- Slug: `appointment-[nome-transizione]`

## Integrazione con Widget

Il sistema è integrato con il `FindDoctorAndAppointmentWidget` che:
1. Crea appuntamenti in stato `Pending`
2. Permette transizioni verso `ReportPending`
3. Gestisce automaticamente le notifiche

## Best Practices

1. **Sempre usare transizioni**: Non modificare direttamente lo stato
2. **Messaggi descrittivi**: Fornire sempre un messaggio nelle transizioni
3. **Gestire le eccezioni**: Le transizioni possono fallire
4. **Testing completo**: Testare tutti i percorsi di transizione
5. **Logging**: Tutte le transizioni sono automaticamente loggare

## File Implementati

### Stati
- `app/States/Appointment/AppointmentState.php` (classe base)
- `app/States/Appointment/Pending.php`
- `app/States/Appointment/Confirmed.php`
- `app/States/Appointment/ReportPending.php`
- `app/States/Appointment/ReportCompleted.php`
- `app/States/Appointment/RefundPending.php`
- `app/States/Appointment/RefundAccepted.php`
- `app/States/Appointment/RefundIntegrate.php`
- `app/States/Appointment/RefundCompleted.php`
- `app/States/Appointment/ProBono.php`
- `app/States/Appointment/Cancelled.php`
- `app/States/Appointment/Rejected.php`
- `app/States/Appointment/NoShow.php`
- `app/States/Appointment/Banned.php`
- `app/States/Appointment/Rescheduled.php`

### Transizioni
- `app/States/Appointment/Transitions/BaseTransition.php`
- `app/States/Appointment/Transitions/PendingToConfirmed.php`
- `app/States/Appointment/Transitions/PendingToRejected.php`
- `app/States/Appointment/Transitions/ConfirmedToReportPending.php`
- `app/States/Appointment/Transitions/ConfirmedToCancelled.php`
- `app/States/Appointment/Transitions/ConfirmedToNoShow.php`
- `app/States/Appointment/Transitions/NoShowToBanned.php`
- `app/States/Appointment/Transitions/ReportPendingToReportCompleted.php`
- `app/States/Appointment/Transitions/ReportCompletedToRefundPending.php`
- `app/States/Appointment/Transitions/ReportCompletedToProBono.php`
- `app/States/Appointment/Transitions/RefundPendingToRefundAccepted.php`
- `app/States/Appointment/Transitions/RefundPendingToRefundIntegrate.php`
- `app/States/Appointment/Transitions/RefundPendingToRefundCompleted.php`
- `app/States/Appointment/Transitions/RefundAcceptedToRefundCompleted.php`
- `app/States/Appointment/Transitions/RefundIntegrateToRefundCompleted.php`

## Collegamenti

- [AppointmentStatusEnum](../app/Enums/AppointmentStatusEnum.php)
- [Appointment Model](../app/Models/Appointment.php)
- [User States Pattern](user-states.md)
- [BaseTransition Pattern](../app/States/User/Transitions/BaseTransition.php)

*Ultimo aggiornamento: Gennaio 2025 - Aggiunta stato RefundIntegrate mancante nelle traduzioni* 