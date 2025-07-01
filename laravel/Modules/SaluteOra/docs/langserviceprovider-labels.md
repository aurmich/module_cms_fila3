# LangServiceProvider: Label automatiche nei Filament Forms (modulo SaluteOra)

## Nota
In questo modulo le label dei campi sono gestite esclusivamente tramite LangServiceProvider e i file di traduzione. Non va mai usato il metodo `->label()`, `->placeholder()`, `->helperText()` nei componenti Filament.

## Esempio pratico - FindDoctorAndAppointmentWidget
```php
// ✅ CORRETTO: la label viene risolta automaticamente
Placeholder::make('studio_name')
    ->content(function (Get $get) {
        // logica per contenuto
    }),

// ✅ CORRETTO: la label viene risolta automaticamente  
Textarea::make('notes')
    ->rows(3)
    ->columnSpan('full')
    ->maxLength(500),

// ❌ ERRATO: mai usare label esplicite
Textarea::make('notes')
    ->label('Note Aggiuntive') // NON FARE!
    ->placeholder('Inserisci note...') // NON FARE!
    ->helperText('Campo opzionale') // NON FARE!
```

## Struttura File di Traduzione
Le traduzioni seguono la struttura espansa in `lang/it/fields.php`:

```php
return [
    'studio_name' => [
        'label' => 'Studio',
        'placeholder' => 'Nome dello studio selezionato',
        'helper_text' => 'Studio dentistico per la prenotazione',
        'description' => 'Informazioni sullo studio medico selezionato',
    ],
    
    'notes' => [
        'label' => 'Note Aggiuntive',
        'placeholder' => 'Inserisci eventuali note o richieste particolari...',
        'helper_text' => 'Informazioni aggiuntive per il tuo appuntamento (opzionale)',
        'description' => 'Campo per comunicazioni speciali o richieste particolari',
    ],
    
    // Altri campi...
];
```

## Meccanismo Automatico
Il LangServiceProvider genera automaticamente le chiavi nel formato:
- `saluteora::fields.{nome_campo}.label`
- `saluteora::fields.{nome_campo}.placeholder`  
- `saluteora::fields.{nome_campo}.helper_text`
- `saluteora::fields.{nome_campo}.description`

## Vantaggi
1. **Coerenza**: Tutte le etichette seguono lo stesso pattern
2. **Manutenibilità**: Traduzioni centralizzate nei file di lingua
3. **Automazione**: Chiavi mancanti vengono create automaticamente
4. **Multilingua**: Supporto nativo per più lingue

## Implementazione Widget Corretta
Nel `FindDoctorAndAppointmentWidget` tutti i campi seguono questa regola:

### Step di Conferma
- `studio_name` → `Placeholder::make('studio_name')` (senza ->label())
- `doctor_name` → `Placeholder::make('doctor_name')` (senza ->label())  
- `appointment_date_display` → `Placeholder::make('appointment_date_display')` (senza ->label())
- `appointment_time_display` → `Placeholder::make('appointment_time_display')` (senza ->label())
- `notes` → `Textarea::make('notes')` (senza ->label())

### Altri Step
- `studio_id` → `RadioCollection::make('studio_id')` (senza ->label())
- `doctor_id` → `Select::make('doctor_id')` (senza ->label())
- `appointment_time` → `RadioCollection::make('appointment_time')` (senza ->label())

## Motivazione e dettagli
Vedi la [doc generale in Xot](../../Xot/docs/langserviceprovider-labels.md) per motivazione, vantaggi e struttura dei file di lingua.

## Collegamenti
- [Doc generale LangServiceProvider in Xot](../../Xot/docs/langserviceprovider-labels.md)
- [File traduzioni fields.php](../lang/it/fields.php)
- [FindDoctorAndAppointmentWidget](../app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php)

**Questa regola è obbligatoria per tutti i moduli.**

## Collegamenti tra versioni di langserviceprovider-labels.md
* [langserviceprovider-labels.md](../../Xot/docs/langserviceprovider-labels.md)

# Gestione Label con LangServiceProvider

## Regola Fondamentale
NON utilizzare mai il metodo `->label()`, `->placeholder()`, `->helperText()` nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider`.

## Struttura Corretta
```php
// Nel componente Filament
Forms\Components\TextInput::make('first_name')
    ->required()
    ->maxLength(255);

// Nel file di traduzione (lang/it/fields.php)
return [
    'first_name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'helper_text' => 'Il tuo nome di battesimo',
        'description' => 'Nome come appare sui documenti ufficiali'
    ]
];
```

## Vantaggi
1. Gestione centralizzata delle traduzioni
2. Supporto multilingua nativo
3. Manutenzione semplificata
4. Performance ottimizzate
5. Coerenza nell'interfaccia utente
6. Automazione delle chiavi mancanti

## Implementazione Completata
✅ **FindDoctorAndAppointmentWidget** - Tutti i campi seguono il pattern LangServiceProvider
✅ **File fields.php** - Struttura espansa implementata con tutte le chiavi
✅ **Documentazione** - Aggiornata con esempi pratici

## Collegamenti
- [Documentazione Traduzioni](translations.md)
- [Best Practices Filament](filament-wizard-best-practices.md)
- [Guida Sviluppatori](guida-sviluppatori.md)

