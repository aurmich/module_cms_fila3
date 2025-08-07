# Array to String Conversion - Errore Registrazione Pazienti

## 🚨 Errore Critico Identificato

**Data**: 26 Giugno 2025  
**Contesto**: Registrazione paziente tramite `RegistrationWidget`  
**File coinvolto**: `Modules\SaluteOra\Actions\Patient\RegisterAction.php`  
**Linea**: 30  

## Descrizione dell'Errore

```
Illuminate\Database\QueryException
Array to string conversion (Connection: salute_ora, SQL: insert into `users` (...) values (...))
```

### Stack Trace Principale

```
Modules\SaluteOra\Actions\Patient\RegisterAction.php :30
public function execute(UserContract $record,array $data): Patient
{
    return DB::transaction(function () use ($data) {
        // 🚨 ERRORE QUI: $data contiene array per attachments
        $patient = Patient::create($data);
        //-------------------------------------------------
        $attachments = Patient::$attachments;
        foreach ($attachments as $attachment) {
            $patient->addMediaFromDisk($data[$attachment],'local')
                ->toMediaCollection($attachment);
        }
```

## Analisi della Causa Root

### 1. **Conflitto Architetturale**

Il problema deriva da un conflitto tra due approcci per gestire gli attachments:

#### Approccio A: Colonne Database (attuale - problematico)
- **Migrazione**: `2025_04_01_000007_create_users_table.php` linee 79-83
```php
foreach(Patient::$attachments as $attachment){
    if (! $this->hasColumn($attachment)) {
        $table->string($attachment)->nullable()->after('type');
    }
}
```

#### Approccio B: Spatie Media Library (corretto)
- **Modello**: `Patient.php` usa `InteractsWithMedia` trait
- **Collections**: Definite in `registerMediaCollections()`
- **Action**: Codice alle linee 34-39 per gestire media

### 2. **Dati Problematici**

I dati POST contengono array per gli attachments:
```json
"health_card":[["session-uploads/.../file1.jpg","session-uploads/.../file2.pdf"],{"s":"arr"}],
"identity_document":[["session-uploads/.../file1.jpg","session-uploads/.../file2.pdf"],{"s":"arr"}],
"isee_certificate":[["session-uploads/.../file1.jpg","session-uploads/.../file2.pdf"],{"s":"arr"}],
"pregnancy_certificate":[["session-uploads/.../file1.jpg","session-uploads/.../file2.pdf"],{"s":"arr"}]
```

### 3. **Problema nel RegisterAction**

```php
// PROBLEMA: Passa tutto $data a create(), inclusi gli array di attachments
$patient = Patient::create($data);

// Ma subito dopo tenta di gestire gli attachments correttamente
foreach ($attachments as $attachment) {
    $patient->addMediaFromDisk($data[$attachment],'local')
        ->toMediaCollection($attachment);
}
```

## Soluzioni Documentate

### Soluzione 1: Filtro dei Dati nel RegisterAction (Consigliata)

**Approccio**: Separare i dati per creazione modello dai dati per attachments

```php
public function execute(UserContract $record, array $data): Patient
{
    return DB::transaction(function () use ($data) {
        
        // 1. Separa dati per il modello dai dati attachments
        $attachments = Patient::$attachments;
        $modelData = collect($data)->except($attachments)->toArray();
        $attachmentData = collect($data)->only($attachments)->toArray();
        
        // 2. Crea il paziente solo con i dati del modello
        $patient = Patient::create($modelData);
        
        // 3. Gestisce gli attachments separatamente
        foreach ($attachments as $attachment) {
            if (isset($attachmentData[$attachment]) && !empty($attachmentData[$attachment])) {
                // Gestisci l'array di file paths
                $filePaths = is_array($attachmentData[$attachment]) 
                    ? $attachmentData[$attachment] 
                    : [$attachmentData[$attachment]];
                
                foreach ($filePaths as $filePath) {
                    if (is_string($filePath) && !empty($filePath)) {
                        $patient->addMediaFromDisk($filePath, 'local')
                            ->toMediaCollection($attachment);
                    }
                }
            }
        }
        
        // Resto della logica...
    });
}
```

### Soluzione 2: Rimozione Campi dalla Migrazione

**Approccio**: Rimuovere le colonne attachments dalla tabella users

```php
// Nuova migrazione per rimuovere colonne attachments
foreach(Patient::$attachments as $attachment) {
    if ($this->hasColumn($attachment)) {
        $table->dropColumn($attachment);
    }
}
```

**Consequenze**:
- ✅ Elimina il conflitto architetturale
- ✅ Forza l'uso di Media Library
- ⚠️ Richiede migrazione dati esistenti
- ⚠️ Breaking change per codice esistente

### Soluzione 3: Rimozione da $fillable (Parziale)

**Approccio**: Rimuovere campi attachments da `$fillable`

```php
// In Patient.php
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

**Problema**: Non risolve completamente perché `create($data)` potrebbe ancora tentare di passare i dati.

### Soluzione 4: Casting Personalizzato (Temporanea)

**Approccio**: Aggiungere cast per convertire array in JSON

```php
protected function casts(): array
{
    return [
        ...parent::casts(),
        'date_of_birth' => 'date',
        // Cast per attachments (soluzione temporanea)
        'health_card' => 'json',
        'identity_document' => 'json',
        'isee_certificate' => 'json', 
        'pregnancy_certificate' => 'json',
    ];
}
```

**Problemi**:
- 🚨 Crea inconsistenza architettuale
- 🚨 Dati duplicati (DB + Media Library)
- 🚨 Sincronizzazione complessa

## Raccomandazione Finale

### Soluzione Consigliata: Combinazione 1 + 2

1. **Immediato**: Implementare **Soluzione 1** per fix rapido
2. **A medio termine**: Implementare **Soluzione 2** per pulizia architettuale
3. **Aggiornare documentazione**: Aggiornare `spatie_media_library_implementation.md`

### Step di Implementazione

1. **Fix Urgente**:
   ```bash
   # Modificare RegisterAction con filtro dati
   git add laravel/Modules/SaluteOra/app/Actions/Patient/RegisterAction.php
   git commit -m "fix: filtro dati attachments in RegisterAction"
   ```

2. **Test**:
   ```bash
   # Test registrazione paziente
   php artisan test --filter=PatientRegistrationTest
   ```

3. **Pulizia Architettuale**:
   ```bash
   # Nuova migrazione per rimuovere colonne attachments
   php artisan make:migration remove_attachment_columns_from_users_table --path=Modules/SaluteOra/database/migrations
   ```

4. **Documentazione**:
   ```bash
   # Aggiornare docs
   # - spatie_media_library_implementation.md
   # - patient_media_library_fix.md (attualmente vuoto)
   ```

## Prevenzione Errori Simili

### Pattern da Seguire

1. **Separazione delle Responsabilità**:
   - Modello: solo dati persistenti diretti
   - Media Library: gestione file e attachments
   - Actions: coordinamento tra i due

2. **Validazione Dati**:
   ```php
   // Sempre validare e filtrare dati prima del create()
   $modelData = collect($data)->except(['attachments', 'files'])->toArray();
   ```

3. **Testing**:
   ```php
   // Test specifici per gestione attachments
   public function test_patient_registration_with_attachments()
   {
       $data = [
           'name' => 'Test Patient',
           'health_card' => ['session-uploads/test.pdf'],
           // ...
       ];
       
       $patient = app(RegisterAction::class)->execute(new User(), $data);
       
       $this->assertInstanceOf(Patient::class, $patient);
       $this->assertTrue($patient->hasAttachment('health_card'));
   }
   ```

## Collegamenti e Documentazione Correlata

### File da Aggiornare
- 📝 `laravel/Modules/SaluteOra/docs/spatie_media_library_implementation.md`
- 📝 `laravel/Modules/SaluteOra/docs/patient_media_library_fix.md` (attualmente vuoto)
- 🔗 `docs/errori_gravi/duplicate-form-logic.md`

### Regole da Creare
- 📋 `.cursor/rules/patient-attachment-handling.mdc`
- 📋 `.windsurf/rules/patient-attachment-handling.mdc`

### Testing da Implementare
- 🧪 `Tests/Feature/Patient/PatientRegistrationTest.php`
- 🧪 `Tests/Unit/Actions/RegisterActionTest.php`

## Impatto e Priorità

### Priorità: 🚨 **CRITICA**
- ❌ **Sistema di registrazione pazienti non funzionale**
- ❌ **Impossibile completare workflow di onboarding**
- ❌ **Blocca funzionalità core dell'applicazione**

### Tempo Stimato
- **Fix immediato**: 2-4 ore
- **Pulizia architettuale**: 1-2 giorni
- **Testing completo**: 1 giorno

### Rischio
- **Alto**: Modifica logica core di registrazione
- **Mitigazione**: Test approfonditi e deploy graduale

---

**Ultimo aggiornamento**: 26 Giugno 2025  
**Autore**: Sistema di documentazione automatica  
**Review**: Richiesta per team di sviluppo  
**Status**: 🚨 **URGENTE - RICHIEDE AZIONE IMMEDIATA** 