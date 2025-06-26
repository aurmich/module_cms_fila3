# Errore "Array to string conversion" durante Registrazione Paziente

## Descrizione dell'Errore

**Errore**: `Illuminate\Database\QueryException: Array to string conversion`

**Query SQL problematica**:
```sql
insert into `users` (..., `certifications`, `last_dental_visit`, `dental_problems`, `health_card`, `identity_document`, `isee_certificate`, `pregnancy_certificate`, ...) 
values (..., ?, 2025-06-26, ?, ?, ?, ?, ?, ...)
```

**File coinvolto**: `Modules/SaluteOra/app/Actions/Patient/RegisterAction.php:30`

**Contesto**: L'errore si verifica durante la registrazione di un paziente tramite il `RegistrationWidget` quando vengono inviati file allegati.

## Analisi del Problema

### Causa Principale

Il problema deriva da un **conflitto architetturale** tra due approcci di gestione degli allegati:

1. **Approccio Database**: I campi `health_card`, `identity_document`, `isee_certificate`, `pregnancy_certificate` sono definiti come colonne `string` nella tabella `users`
2. **Approccio Media Library**: Gli stessi campi vengono gestiti tramite Spatie Media Library come collezioni di media

### Dettagli Tecnici

#### 1. Configurazione Form (XotBaseResource.php:187-233)
```php
// I FileUpload sono configurati come multipli
Forms\Components\FileUpload::make($attachment)
    ->multiple()  // ← Restituisce ARRAY
    ->afterStateUpdated(function ($state, Forms\Set $set) use ($attachment) {
        // Salva array di percorsi di sessione
        $set($attachment, $sessionFiles); // ← Imposta ARRAY
    });
```

#### 2. Modello Patient (Patient.php:95-105)
```php
protected $fillable = [
    'health_card',        // ← Campo fillable
    'identity_document',  // ← Campo fillable  
    'isee_certificate',   // ← Campo fillable
    'pregnancy_certificate', // ← Campo fillable
];

public static array $attachments = [
    'health_card', 'identity_document', 
    'isee_certificate', 'pregnancy_certificate'
];
```

#### 3. Migrazione Database (2025_04_01_000007_create_users_table.php:78-82)
```php
foreach(Patient::$attachments as $attachment){
    if (! $this->hasColumn($attachment)) {
        $table->string($attachment)->nullable(); // ← Colonna STRING
    }
}
```

#### 4. Action di Registrazione (RegisterAction.php:27-30)
```php
public function execute(UserContract $record,array $data): Patient
{
    return DB::transaction(function () use ($data) {
        // PROBLEMA: $data contiene array per gli allegati
        // ma le colonne database sono string
        $patient = Patient::create($data); // ← ERRORE QUI
```

### Flusso dell'Errore

1. **Form Submit**: I FileUpload multipli inviano array di percorsi
2. **Widget Processing**: `RegistrationWidget::register()` passa i dati all'action
3. **Database Insert**: `Patient::create($data)` tenta di inserire array come stringhe
4. **MySQL Error**: "Array to string conversion" durante l'INSERT

## Soluzioni Proposte

### Soluzione 1: Rimozione Campi dal Fillable (RACCOMANDATA)

#### Modifiche Necessarie

**A. Modifica Patient.php**
```php
// RIMUOVERE i campi allegati dal $fillable
protected $fillable = [
    'first_name',
    'last_name', 
    'date_of_birth',
    'gender',
    'address',
    'phone',
    'last_dental_visit',
    'dental_problems',
    // RIMUOVERE QUESTI:
    // 'health_card',
    // 'identity_document', 
    // 'isee_certificate',
    // 'pregnancy_certificate',
];
```

**B. Modifica RegisterAction.php**
```php
public function execute(UserContract $record,array $data): Patient
{
    return DB::transaction(function () use ($data) {
        // Separare i dati degli allegati
        $attachments = Patient::$attachments;
        $attachmentData = [];
        
        foreach ($attachments as $attachment) {
            if (isset($data[$attachment])) {
                $attachmentData[$attachment] = $data[$attachment];
                unset($data[$attachment]); // Rimuovere dal $data principale
            }
        }

        // Creare il paziente senza i campi allegati
        $patient = Patient::create($data);

        // Processare gli allegati tramite Media Library
        foreach ($attachmentData as $attachment => $files) {
            if (!empty($files) && is_array($files)) {
                foreach ($files as $file) {
                    $patient->addMediaFromDisk($file, 'local')
                        ->toMediaCollection($attachment);
                }
            }
        }

        // Resto della logica esistente...
        if (isset($data['privacy_acceptance'])) {
            $patient->consents()->create([
                'type' => 'privacy',
                'accepted' => true,
                'accepted_at' => now(),
            ]);
        }

        // ...
    });
}
```

### Soluzione 2: Rimozione Colonne Database (ALTERNATIVA)

Se gli allegati sono gestiti solo tramite Media Library:

**A. Nuova Migrazione**
```php
// 2025_06_26_120000_remove_attachment_columns_from_users_table.php
return new class extends XotBaseMigration
{
    protected string $table = 'users';

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            $attachments = ['health_card', 'identity_document', 'isee_certificate', 'pregnancy_certificate'];
            
            foreach ($attachments as $attachment) {
                if ($this->hasColumn($attachment)) {
                    $table->dropColumn($attachment);
                }
            }
        });
    }
};
```

**B. Mantenere il fillable** per backward compatibility nei form

### Soluzione 3: Conversione a JSON (MENO RACCOMANDATA)

**A. Modifica Migrazione**
```php
foreach(Patient::$attachments as $attachment){
    if (! $this->hasColumn($attachment)) {
        $table->json($attachment)->nullable(); // JSON invece di string
    }
}
```

**B. Aggiunta Cast nel Modello**
```php
protected function casts(): array
{
    return [
        ...parent::casts(),
        'health_card' => 'array',
        'identity_document' => 'array',
        'isee_certificate' => 'array', 
        'pregnancy_certificate' => 'array',
    ];
}
```

## Raccomandazioni

### Soluzione Preferita

**Implementare la Soluzione 1** perché:

1. **Coerenza Architetturale**: Usa solo Spatie Media Library per gli allegati
2. **Semplicità**: Elimina la duplicazione di logica
3. **Sicurezza**: Gestione centralizzata dei file
4. **Manutenibilità**: Un solo punto di verità per gli allegati

### Test di Verifica

Dopo l'implementazione, testare:

1. **Registrazione Paziente**: Verificare che funzioni senza errori
2. **Upload Allegati**: Controllare che i file vengano salvati correttamente
3. **Visualizzazione**: Assicurarsi che gli allegati siano accessibili
4. **Media Collections**: Verificare l'integrità delle collezioni Media Library

### Impatti Collaterali

- **Form Filament**: Potrebbero necessitare aggiornamenti per accedere agli allegati tramite Media Library
- **API/Export**: Aggiornare eventuali endpoint che accedevano ai campi diretti
- **Validazioni**: Rivedere le regole di validazione per gli allegati

## Best Practices Future

1. **Evitare Doppia Gestione**: Non gestire mai lo stesso dato sia nel database che tramite Media Library
2. **Documentare Architettura**: Chiarire se un campo è gestito via database o Media Library
3. **Test Integrazione**: Testare sempre il flusso completo form → action → database
4. **Validazione Tipizzazione**: Usare PHPStan per identificare problemi di tipizzazione

## Collegamenti Correlati

- [Patient Media Library Fix](../patient_media_library_fix.md)
- [Spatie Media Library Implementation](../spatie_media_library_implementation.md)
- [Model Architecture](../model-architecture.md)
- [Filament Best Practices](../filament-best-practices.mdc)

## Riferimenti Tecnici

- **Stack Trace Completo**: Vedere log di debug per il traceback completo
- **Configurazione Media Library**: `Patient.php:167-193`
- **Schema Form**: `XotBaseResource.php:187-233`
- **Migrazione Tabella**: `2025_04_01_000007_create_users_table.php:78-82`

---

*Ultimo aggiornamento: 26 giugno 2025*  
*Autore: Sistema di Documentazione Automatica*  
*Stato: Identificazione Problema Completata, Soluzione Pendente* 