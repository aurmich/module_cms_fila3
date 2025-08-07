# Documentazione File Traduzione: edit_patient_attachments.php

## Panoramica

Il file `edit_patient_attachments.php` contiene le traduzioni per la gestione e il caricamento dei documenti allegati del paziente nel sistema SaluteOra. Questo file è conforme agli **standard di qualità** del modulo e implementa la struttura espansa obbligatoria.

## Struttura del File

### Sezioni Principali

#### 1. Model
```php
'model' => [
    'label' => 'Documenti Paziente',
    'plural_label' => 'Documenti Pazienti', 
    'description' => 'Gestione e caricamento documenti allegati del paziente',
],
```

#### 2. Page
```php
'page' => [
    'title' => 'Modifica Documenti Paziente',
    'heading' => 'Gestione Documenti Allegati',
    'description' => 'Carica e gestisci i documenti necessari per il paziente',
    'subheading' => 'Documenti richiesti per completare la registrazione',
],
```

#### 3. Actions
- **save**: Azione per salvare i documenti caricati
- **cancel**: Azione per annullare le modifiche

#### 4. Fields
Tre tipologie di documenti sanitari:

##### Certificato Medico di Gravidanza
- **Scopo**: Attestazione stato di gravidanza per prestazioni speciali
- **Rilasciato da**: Ginecologo o medico di base
- **Formati**: JPG, JPEG, PNG, PDF
- **Dimensione max**: 5MB

##### Certificato ISEE Completo
- **Scopo**: Accesso ad agevolazioni economiche e prestazioni a tariffa ridotta
- **Rilasciato da**: CAF o INPS
- **Formati**: JPG, JPEG, PNG, PDF
- **Dimensione max**: 5MB

##### Tessera Sanitaria
- **Scopo**: Identificazione paziente e accesso prestazioni SSN
- **Tipologie**: Tessera sanitaria nazionale, STP, ENI
- **Obbligatorietà**: Richiesta per identificazione paziente
- **Formati**: JPG, JPEG, PNG, PDF
- **Dimensione max**: 5MB

#### 5. Navigation
Configurazione per la navigazione nell'interfaccia Filament:
- **Gruppo**: Gestione Pazienti
- **Icona**: heroicon-o-document-text

#### 6. Messages
Messaggi di feedback per le operazioni:
- Upload success/error
- Delete success/error
- Validation errors
- Processing status
- Multiple files handling

#### 7. Notifications
Notifiche push per l'utente:
- Documenti aggiornati
- Documenti obbligatori mancanti

## Standard di Qualità Applicati

### ✅ Conformità Completa
- **Strict Types**: `declare(strict_types=1);` presente
- **Array Syntax**: Sintassi breve `[]` utilizzata
- **Struttura Espansa**: Ogni campo con label, placeholder, help, description, helper_text
- **Helper Text**: Correttamente impostati a stringa vuota `''` dove appropriato
- **Traduzioni Semantiche**: Terminologia medica italiana corretta
- **Validazione**: Regole di validazione complete per ogni documento

### 🏥 Terminologia Sanitaria Specializzata
- **ISEE**: Indicatore Situazione Economica Equivalente
- **STP**: Straniero Temporaneamente Presente
- **ENI**: Europeo Non Iscritto
- **SSN**: Servizio Sanitario Nazionale
- **CAF**: Centro di Assistenza Fiscale
- **INPS**: Istituto Nazionale Previdenza Sociale

## Validazione e Controlli

### Formati File Supportati
- **Immagini**: JPG, JPEG, PNG
- **Documenti**: PDF
- **Dimensione Massima**: 5MB per file

### Regole di Validazione
- Controllo formato file (MIME type)
- Controllo dimensione massima
- Validazione obbligatorietà (tessera sanitaria)
- Controllo integrità file

## Integrazione con Sistema

### Utilizzo in Filament
Il file è utilizzato da:
- **Resources**: PatientResource per gestione documenti
- **Pages**: EditPatientAttachments page
- **Widgets**: Dashboard widgets per stato documenti
- **Actions**: Upload, delete, validation actions

### Spatie Media Library
Integrazione con Spatie Media Library per:
- Gestione collezioni documenti
- Storage sicuro file sensibili
- Controllo accessi e autorizzazioni
- Backup e versioning documenti

## Manutenzione e Aggiornamenti

### Procedure di Aggiornamento
1. **Backup**: Sempre backup prima di modifiche
2. **Validazione**: Controllo sintassi e struttura
3. **Test**: Verifica funzionalità in ambiente di test
4. **Documentazione**: Aggiornamento documentazione correlata

### Controlli di Qualità
- PHPStan validation (livello 9+)
- Controllo coerenza multilingua
- Test integrazione Filament
- Verifica terminologia medica

## Collegamenti Bidirezionali

### Documentazione Correlata
- [Translation Quality Standards](../translation_quality_standards.md)
- [Spatie Media Library Implementation](../spatie_media_library_implementation.md)
- [Patient Management](../patient_management.md)
- [Filament Resources Implementation](../filament_resources_implementation.md)

### Root Documentation
- [Translation Rules](../../../../docs/translation-rules.md)
- [File Upload Best Practices](../../../../docs/file-upload-best-practices.md)
- [Healthcare Data Standards](../../../../docs/healthcare-data-standards.md)

## Note Tecniche

### Performance
- Lazy loading per documenti grandi
- Compressione automatica immagini
- Cache metadata documenti
- Ottimizzazione query database

### Sicurezza
- Validazione server-side rigorosa
- Storage privato per documenti sensibili
- Audit trail modifiche documenti
- Controllo accessi basato su ruoli

### Accessibilità
- Label descrittive per screen reader
- Supporto navigazione da tastiera
- Contrasto colori conforme WCAG
- Messaggi di errore chiari e comprensibili

---

**Ultima modifica**: 2025-08-07  
**Versione**: 1.0  
**Autore**: Sistema di documentazione automatica SaluteOra  
**Stato**: Conforme agli standard di qualità del modulo
