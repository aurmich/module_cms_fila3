# Architettura dei Modelli in SaluteOra

## Panoramica

Questo documento descrive l'architettura standardizzata dei modelli all'interno del modulo SaluteOra, con particolare attenzione alla gerarchia di ereditarietà e alle convenzioni che tutti gli sviluppatori devono rispettare.

## Gerarchia di Ereditarietà

### 1. `BaseModel`

Tutti i modelli nel modulo SaluteOra **DEVONO** estendere `BaseModel` invece di estendere direttamente `Illuminate\Database\Eloquent\Model`. Questa è una regola fondamentale dell'architettura che garantisce:

- Configurazione uniforme della connessione al database (`salute_ora`)
- Funzionalità standard come `HasMedia` e `InteractsWithMedia`
- Gestione automatica dell'audit trail tramite il trait `Updater`
- Configurazione coerente dei tipi di casting
- Gestione standardizzata delle factory

```php
<?php

namespace Modules\SaluteOra\Models;

// CORRETTO: estende BaseModel
class CorrectModel extends BaseModel
{
    // Implementazione specifica
}

// ERRATO: estende direttamente Model
class WrongModel extends \Illuminate\Database\Eloquent\Model
{
    // Implementazione errata
}
```

### 2. Ereditarietà Specializzata

In alcuni casi, potrebbero esistere modelli base intermedi che estendono `BaseModel` e aggiungono funzionalità specifiche per un dominio:

```php
// Modello base specializzato
class MedicalEntityModel extends BaseModel
{
    // Funzionalità comuni a tutte le entità mediche
}

// Modello specifico
class Doctor extends MedicalEntityModel
{
    // Funzionalità specifiche per i dottori
}
```

## Caratteristiche di `BaseModel`

`BaseModel` fornisce diverse funzionalità importanti:

1. **Configurazione Database**:
   - Connessione predefinita a `salute_ora`
   - Chiave primaria configurata come `id` di tipo string
   - Paginazione impostata a 30 elementi per pagina

2. **Traits Incorporati**:
   - `HasFactory`: Supporto per le factory di Eloquent
   - `InteractsWithMedia`: Gestione di file e media tramite Spatie Media Library
   - `Updater`: Tracciamento automatico di chi crea/modifica i record

3. **Implementazioni di Interfacce**:
   - `HasMedia`: Interfaccia richiesta da Spatie Media Library

4. **Casting Automatico**:
   - Cast di timestamp (`created_at`, `updated_at`, ecc.) a `datetime`
   - Cast di ID e UUID a `string`
   - Cast automatico dei campi di audit trail

## Convenzioni di Implementazione

1. **Proprietà Personalizzate**:
   I modelli possono definire proprietà personalizzate, ma non devono sovrascrivere le configurazioni base di `BaseModel` senza una ragione valida:

   ```php
   class Studio extends BaseModel
   {
       // Mantenere la connessione di BaseModel a meno che non ci sia una ragione specifica
       // per cambiarla
       protected $connection = 'salute_ora';
       
       // Definire i fillable specifici di questo modello
       protected $fillable = [
           'name',
           'email',
           // ...
       ];
   }
   ```

2. **Traits Aggiuntivi**:
   I modelli possono utilizzare traits aggiuntivi per estendere le funzionalità:

   ```php
   class Studio extends BaseModel
   {
       use SoftDeletes;
       use LogsActivity;
       use HasAddress;
       
       // Implementazione...
   }
   ```

3. **Relazioni**:
   Le relazioni devono essere implementate in modo coerente:

   ```php
   class Studio extends BaseModel
   {
       public function doctors(): HasMany
       {
           return $this->hasMany(Doctor::class, 'tenant_id');
       }
   }
   ```

## Errori Comuni

### 1. Estendere Direttamente `Model`

```php
// ERRATO
class Studio extends Model
{
    // ...
}
```

Questo approccio bypassa tutte le configurazioni e le funzionalità fornite da `BaseModel`, creando incoerenza nell'applicazione.

### 2. Definire Manualmente la Connessione

```php
// ERRATO se non necessario
class Studio extends BaseModel
{
    protected $connection = 'mysql'; // Sovrascrive la connessione salute_ora senza necessità
}
```

### 3. Omettere Traits Obbligatori

```php
// ERRATO se questi traits sono richiesti per questo tipo di modello
class Studio extends BaseModel
{
    // Manca SoftDeletes, LogsActivity, ecc. se richiesti
}
```

## Migrazione da Model a BaseModel

Quando si migra un modello da `Model` a `BaseModel`, è importante:

1. Verificare la compatibilità delle proprietà definite
2. Adattare la configurazione della connessione al database
3. Implementare correttamente gli eventi e i mutatori
4. Adattare i casting specifici per compatibilità con `BaseModel`

## Conclusione

Seguire l'architettura standardizzata dei modelli in SaluteOra è essenziale per mantenere la coerenza, la manutenibilità e la scalabilità dell'applicazione. Tutti i modelli devono estendere `BaseModel` e seguire le convenzioni documentate in questo documento.

## Riferimenti

- [Documentazione Laravel Eloquent](https://laravel.com/docs/10.x/eloquent)
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)
- [Single Table Inheritance](model_inheritance.md)