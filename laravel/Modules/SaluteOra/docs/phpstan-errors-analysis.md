# PHPStan Errors Analysis - SaluteOra Module

## Data di Analisi

31 Luglio 2025 - Aggiornamento

## Errori Risolti

### ✅ PatientResource/Pages/ListPatients - Return Type Mismatch

**Errore**: `getHeaderWidgets() should return array<class-string>`

**Soluzione**: Corretto il metodo per restituire array di class-string invece di WidgetConfiguration

### ✅ ReportResource/Pages/ViewReport - Empty() Check Issues

**Errore**: `Variable $state in empty() always exists and is not falsy`

**Soluzione**: Sostituiti tutti gli `empty()` con controlli specifici `$state === null || count($state) === 0`

### ✅ ReportResource/Pages/ViewReport - Undefined notify() Method

**Errore**: `Call to an undefined method notify()`

**Soluzione**: Sostituito con `Notification::make()` e commentato il codice non funzionante

## Errori Rimanenti da Risolvere

### 1. StudioResource/RelationManagers/DoctorsRelationManager - Return Type Mismatch

**Errore**: `getTableColumns() should return array<string, Filament\Tables\Columns\Column> but returns array<string, Column|IconStateGroupColumn>`

**File**: StudioResource/RelationManagers/DoctorsRelationManager.php:42

**Ragionamento**:

- Il metodo getTableColumns() include IconStateGroupColumn che non è un Column standard
- PHPStan non riconosce IconStateGroupColumn come sottotipo di Column
- **Azione**: Correggere il tipo di ritorno o sostituire con componenti standard

### 2. Models/Doctor - DoctorRegistrationWorkflow Class Not Found

**Errori multipli**:

- `Class Modules\SaluteOra\Models\DoctorRegistrationWorkflow not found`
- Generic type issues con HasOne relationship
- Parameter type mismatch nel metodo hasOne()

**File**: Models/Doctor.php:174-176

**Ragionamento**:

- Il modello Doctor fa riferimento a DoctorRegistrationWorkflow che non esiste
- La relazione hasOne() usa una stringa invece di class-string
- I tipi generici non sono specificati correttamente
- **Azione**: Creare il modello mancante o rimuovere la relazione

### 3. DoctorAvailabilityResource - Class Not Found

**Errore**: `Class Modules\SaluteOra\Filament\Resources\DoctorAvailabilityResource not found`

**File**: Pages/CreateDoctorAvailability.php, EditDoctorAvailability.php, ListDoctorAvailabilities.php

**Ragionamento**:

- Le pagine fanno riferimento a una risorsa DoctorAvailabilityResource che non esiste
- Possibili cause: risorsa eliminata ma pagine rimaste, o risorsa spostata/rinominata
- **Azione**: Verificare se la risorsa esiste, altrimenti eliminare le pagine orfane

## Priorità di Risoluzione

1. **Alta**: Models/Doctor - DoctorRegistrationWorkflow (blocca funzionalità core)
2. **Media**: StudioResource/RelationManagers - Return type (problema di tipizzazione)
3. **Bassa**: DoctorAvailabilityResource - Pages orfane (non bloccanti)

## Strategie di Risoluzione

### Per DoctorRegistrationWorkflow

- Opzione 1: Creare il modello mancante con struttura appropriata
- Opzione 2: Rimuovere la relazione se non necessaria
- Opzione 3: Sostituire con un modello esistente (es. AppointmentWorkflow)

### Per IconStateGroupColumn

- Opzione 1: Estendere la classe per implementare l'interfaccia Column
- Opzione 2: Sostituire con componenti Filament standard
- Opzione 3: Aggiornare il tipo di ritorno per includere il tipo custom

### Per DoctorAvailabilityResource

- Opzione 1: Creare la risorsa mancante
- Opzione 2: Eliminare le pagine orfane
- Opzione 3: Reindirizzare a una risorsa esistente
- Relazione hasOne() con classe mancante
- **Azione**: Verificare se la classe esiste o rimuovere la relazione

## Priorità di Correzione

### Alta Priorità
1. **Class Not Found errors** - Impediscono il caricamento delle classi
2. **Missing model relationships** - Causano errori runtime

### Media Priorità  
3. **Return type mismatches** - Problemi di type safety
4. **Parameter count mismatches** - Errori di chiamata metodi

### Bassa Priorità
5. **Empty() redundancy** - Ottimizzazioni di codice

## Checklist Pre-Implementazione

- [ ] Verificare esistenza delle classi referenziate
- [ ] Controllare se le risorse Filament sono effettivamente utilizzate
- [ ] Analizzare le relazioni dei modelli per validità
- [ ] Verificare i tipi di ritorno dei metodi Filament
- [ ] Testare i componenti UI custom utilizzati

## Note Implementative

- Seguire le regole Laraxot per namespace e struttura
- Utilizzare sempre declare(strict_types=1)
- Documentare tutte le proprietà dei modelli con PHPDoc
- Preferire type safety esplicita a mixed types
- Aggiornare documentazione bidirezionale dopo ogni fix

### 6. StudioResource/RelationManagers/DoctorsRelationManager - Return Type Mismatch
**Errore**: `getTableColumns() should return array<string, Filament\Tables\Columns\Column> but returns array<string, Filament\Tables\Columns\Column|Modules\UI\Filament\Tables\Columns\IconStateGroupColumn>`
**File**: StudioResource/RelationManagers/DoctorsRelationManager.php:42

**Ragionamento**:
- Stesso problema del UserResource: uso di componenti UI custom non inclusi nel tipo di ritorno
- Il metodo getTableColumns() deve includere IconStateGroupColumn nel tipo di ritorno
- **Azione**: Aggiornare il PHPDoc del return type per includere il tipo union corretto

### 7. Models/Doctor - DoctorRegistrationWorkflow Class Issues
**Errori Multipli**:
- Class DoctorRegistrationWorkflow not found
- Invalid return type in PHPDoc
- Generic type specification incomplete
- Parameter type mismatch in hasOne()

**Ragionamento**:
- Il modello DoctorRegistrationWorkflow non esiste ma viene referenziato
- La relazione hasOne() è stata aggiunta ma la classe target non esiste
- I generics di Eloquent richiedono specificazione completa dei template types
- **Azione**: Verificare se DoctorRegistrationWorkflow deve essere creato o se la relazione deve essere rimossa

## Priorità di Correzione Aggiornata

### Alta Priorità
1. **DoctorRegistrationWorkflow missing class** - Decisione critica: creare o rimuovere
2. **Class Not Found errors** - Impediscono il caricamento delle classi
3. **Return type mismatches** - Problemi di type safety in Filament

### Media Priorità  
4. **Parameter count mismatches** - Errori di chiamata metodi
5. **Generic type specifications** - Completezza dei template types

### Bassa Priorità
6. **Empty() redundancy** - Ottimizzazioni di codice

## Collegamenti

- [Root PHPStan Documentation](../../../docs/phpstan-fixes.md)
- [Laraxot Conventions](../../../docs/laraxot-conventions.md)
- [Filament Best Practices](../../../docs/filament-best-practices.md)
- [Doctor Model Documentation](./models/doctor.md)
- [Filament Resources Documentation](./filament/resources.md)
