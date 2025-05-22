# Implementazione Corretta dei Form basati su Design Esistenti

## Problema Identificato

Durante l'implementazione del `DoctorResource`, sono stati commessi due errori significativi:

1. **Utilizzo di metodi non supportati**: Il metodo `buttonLabel()` è stato utilizzato sul componente `FileUpload` di Filament, ma questo metodo non esiste.

2. **Discrepanza tra design e implementazione**: Il primo step del wizard è stato implementato in modo diverso rispetto a quanto documentato nei file di design (`/var/www/html/[progetto]/docs/images/13.md`, `/var/www/html/[progetto]/docs/images/13.html`, `/var/www/html/[progetto]/docs/images/13.blade.php`).

## Regola Fondamentale

**Quando si implementa un form basato su design esistenti, è obbligatorio:**

1. Consultare e seguire fedelmente i file di design forniti
2. Verificare che i metodi utilizzati siano effettivamente supportati dai componenti Filament
3. Mantenere coerenza con le implementazioni simili già esistenti nel progetto

## Analisi dei File di Design

### Struttura del Form in 13.blade.php

```php
// Il form contiene:
FilamentForms\Components\TextInput::make('name')  // NOTA: Dovrebbe essere 'full_name' secondo le convenzioni
    ->label('')
    ->placeholder('Nome e Cognome')
    ->required()
    ->maxLength(255)
    ->extraAttributes(['class' => 'rounded-full'])
    ->autocomplete('name')  // NOTA: Dovrebbe essere 'full_name' secondo le convenzioni

FilamentForms\Components\FileUpload::make('certificationFile')
    ->label('Carica certificazione iscrizione Ordine')
    ->disk('public')
    ->directory('certifications')
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
    ->maxSize(10240)
    ->buttonLabel('Carica certificazione iscrizione Ordine')
    ->extraAttributes(['class' => 'rounded-full'])
```

### Metodi Supportati da FileUpload

Il componente `FileUpload` di Filament **non supporta** il metodo `buttonLabel()`. I metodi effettivamente supportati sono:

- `acceptedFileTypes()`
- `directory()`
- `disk()`
- `maxSize()`
- `multiple()`
- `placeholder()`
- `helperText()`

## Implementazione Corretta

L'implementazione corretta del primo step del wizard dovrebbe:

1. Seguire la struttura del form nei file di design
2. Utilizzare solo metodi supportati dai componenti Filament
3. Mantenere coerenza con il `PatientResource` esistente
4. Utilizzare `full_name` (e non `name`) quando si richiede il nome completo in un unico campo

## Best Practices per Evitare Errori Simili

1. **Verifica dei Design**: Prima di implementare, studiare attentamente tutti i file di design forniti
2. **Documentazione Filament**: Consultare la documentazione ufficiale di Filament per verificare i metodi supportati
3. **Riutilizzo del Codice**: Basarsi su implementazioni simili già esistenti nel progetto
4. **Test Incrementali**: Implementare e testare piccole parti alla volta per identificare rapidamente gli errori
5. **Convenzioni di Nomenclatura**: Seguire sempre le convenzioni di nomenclatura del progetto, in particolare:
   - Utilizzare `first_name` e `last_name` per i campi separati
   - Utilizzare `full_name` per il nome completo in un unico campo

## Collegamenti Bidirezionali

- [Compatibilità dei Metodi dei Componenti Filament](../../UI/docs/filament/component-methods-compatibility.md)
- [Best Practices per i Wizard in Filament](../../UI/docs/filament/wizard-best-practices.md)
- [File di Design per il Form di Registrazione](/var/www/html/[progetto]/docs/images/13.blade.php)
- [Convenzione per i Campi dei Nomi Personali](../../Xot/docs/conventions/personal-name-fields.md)
- [Convenzione per il Campo Nome Completo](../../Xot/docs/conventions/full-name-field.md)
