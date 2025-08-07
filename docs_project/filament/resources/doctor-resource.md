# DoctorResource: Step Informazioni Personali

## Regola fondamentale: niente proprietà statiche custom nei resource

Chi estende XotBaseResource **non deve mai** dichiarare o ridefinire:
- `protected static ?string $navigationIcon`
- `protected static ?string $navigationGroup`
- `protected static ?string $translationPrefix`
- `public static function table(...)`
- `public static function getListTableColumns(): array`

**Motivazione:**
- Queste proprietà e metodi sono già gestiti centralmente in XotBaseResource.
- Ridefinirli porta a conflitti, duplicazione, errori di autoload e perdita di coerenza.
- La configurazione va fatta tramite metodi previsti dalla base o direttamente nelle chiamate (es. `__('patient::doctor-resource.first_name')`).

Per la regola generale vedi:
- [Regole XotBaseResource](../../../../Xot/docs/filament/README.md)

## Modifica recente

Nel primo step della registrazione (getPersonalInfoStep) sono ora richiesti i campi:
- **first_name** (nome)
- **last_name** (cognome)
- **email**
- **certification** (certificato PDF)

Il campo `full_name` è stato rimosso in favore di una gestione più normalizzata e per permettere l'invio email già dal primo step.

## Motivazione
- **Invio email**: L'email è ora obbligatoria e raccolta subito, così da poter inviare notifiche e link di continuazione/moderazione.
- **Normalizzazione**: Separare nome e cognome è best practice per la gestione anagrafica e per future estensioni (es. ricerca, report, personalizzazione comunicazioni).
- **Coerenza**: Allineamento con le convenzioni del progetto e con la struttura dei dati degli altri tipi di utente.

## Impatto sul workflow
- Il workflow di registrazione ora salva i dati separati (`first_name`, `last_name`, `email`, `certification`) nello step `personal_info`.
- La creazione del modello Doctor usa questi nuovi campi.

## Gestione campi e Single Table Inheritance (STI)

> **Nota importante:**
> Ogni campo del form (es. `certifications`) deve essere presente nella tabella base `users` a causa dello STI.
> Se aggiungi un campo, aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [DoctorResource.php](../../../../app/Filament/Resources/DoctorResource.php)
- [Workflow di registrazione](../../Models/DoctorRegistrationWorkflow.php)
- [Widget di registrazione generico](../../../User/app/Filament/Widgets/RegistrationWidget.php)
- [Modello Doctor](../../Models/Doctor.md)
- [Gestione campi e migrazioni con STI (README Patient)](../../README.md)
- [Standard Xot: Ereditarietà dei Modelli](../../../../Xot/docs/standards/README.md)
- [Struttura progetto e STI](../../architecture/struttura-progetto.md)
- [Migrazioni e database](../../database/migrations.md) 
