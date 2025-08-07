# Flusso di Registrazione dei Dottori

## Panoramica

Questo documento descrive il flusso di registrazione dei dottori nel modulo Patient, con particolare attenzione alla tabella `doctor_registration_workflows` che gestisce lo stato e l'avanzamento del processo di registrazione.

## Struttura della Tabella `doctor_registration_workflows`

La tabella `doctor_registration_workflows` memorizza informazioni sul processo di registrazione di ciascun dottore, consentendo un flusso multi-step con moderazione.

### Schema della Tabella

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| id | bigint | Identificatore univoco del workflow |
| doctor_id | uuid | Riferimento all'ID del dottore (chiave esterna alla tabella `users`) |
| current_step | string | Step corrente nel processo di registrazione (es. 'personal_info_step', 'certification_step') |
| status | string | Stato della registrazione (es. 'pending_moderation', 'approved', 'rejected') |
| moderation_notes | text | Note opzionali del moderatore in caso di rifiuto |
| started_at | timestamp | Data e ora di inizio del processo di registrazione |
| completed_at | timestamp | Data e ora di completamento del processo di registrazione (null se non completato) |
| last_interaction_at | timestamp | Data e ora dell'ultima interazione dell'utente con il processo |
| session_id | string | ID della sessione per tracciare il processo di registrazione |
| created_at | timestamp | Data e ora di creazione del record |
| updated_at | timestamp | Data e ora dell'ultimo aggiornamento del record |

### Costanti di Stato

```php
// Definite nella classe DoctorRegistrationWorkflow
const STATUS_PENDING_MODERATION = 'pending_moderation';
const STATUS_APPROVED = 'approved';
const STATUS_REJECTED = 'rejected';
```

### Passi del Processo di Registrazione

1. **personal_info_step**: Raccolta delle informazioni personali del dottore
2. **certification_step**: Caricamento delle certificazioni professionali
3. **availability_step**: Impostazione della disponibilità per le visite
4. **review_step**: Revisione di tutte le informazioni prima dell'invio
5. **completed**: Registrazione completata e in attesa di moderazione

## Relazioni

La tabella `doctor_registration_workflows` ha le seguenti relazioni:

- **Doctor**: Relazione uno-a-uno con la tabella `users` (dove `type` = 'doctor')

```php
// Nel modello DoctorRegistrationWorkflow
public function doctor()
{
    return $this->belongsTo(Doctor::class);
}

// Nel modello Doctor
public function workflow()
{
    return $this->hasOne(DoctorRegistrationWorkflow::class);
}
```

## Flusso di Registrazione

1. L'utente inizia il processo di registrazione come dottore
2. Compila i dati personali (nome, cognome, email, ecc.)
3. Carica le certificazioni professionali
4. Imposta la disponibilità per le visite
5. Rivede tutte le informazioni e conferma
6. La registrazione viene messa in stato di attesa moderazione
7. Un amministratore approva o rifiuta la registrazione
8. Se approvata, il dottore riceve un'email di conferma e può accedere al sistema
9. Se rifiutata, il dottore riceve un'email con le note di moderazione e può modificare i dati per ripresentare la richiesta

## Implementazione

La tabella `doctor_registration_workflows` viene creata tramite una migrazione dedicata e gestita dal modello `DoctorRegistrationWorkflow`.

### Connessione al Database

È importante notare che il modello `DoctorRegistrationWorkflow` deve utilizzare la connessione `mysql` che punta al database principale dell'applicazione, dove si trova la tabella `doctor_registration_workflows`. Anche se la tabella `users` potrebbe trovarsi in una connessione diversa, il modello `DoctorRegistrationWorkflow` deve utilizzare la connessione corretta per accedere alla propria tabella.

```php
// Nel modello DoctorRegistrationWorkflow
protected ?string $connection = 'mysql';
```

Questa configurazione è necessaria perché le tabelle `doctor_registration_workflows` e `users` si trovano in database diversi. La relazione tra queste tabelle viene gestita a livello di applicazione tramite il modello `Doctor`, che estende `User` e utilizza la connessione `user`.

## Documentazione Correlata

- [Modello di Ereditarietà](/laravel/Modules/Patient/docs/MODEL_INHERITANCE_PATTERN.md)
- [Mappatura dei Campi Database](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md)
- [Gestione degli Utenti](/docs/user-management.md)
- [Gestione delle Email](/docs/email-doctor-registration.md)
- [Gestione dei File Upload in Filament](/docs/filament-file-uploads.md)
